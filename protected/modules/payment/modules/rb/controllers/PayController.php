<?php

class PayController extends Controller
{
    public $defaultAction = 'order';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('order','result','success','fail'),
                'users'=>array('*'),
            ),
            /*
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('update'),
                'roles'=>array('ADMIN'),
			),
            */
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Output pay form (for more detale see WmPayFormWidget)
     */
    public function actionOrder()
    {
        // Получаем номер заказа из $_GET
        $orderId = intval(Yii::app()->request->getQuery('id'));

        // Получаем код платежной системы
        $IncCurrLabel = Yii::app()->request->getQuery('icl');

        // Инициализируем модель по номеру заказа
        $order = Orders::model()->find('id=:id AND status=:status', array(':id'=>$orderId,':status'=>'NEW'));

        // Если не найдено, выводим ошибку
        if ($order === null)
        {
            Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Заказ с таким номером не найден или у него изменен статус! Для решения проблемы оформите пожалуйста новый заказ!");
        }
        else
        {
            // Заполняем параметры платежной системы
            $mrhLogin = Yii::app()->params['rb_login'];
            $mrhPass1 = Yii::app()->params['rb_pass1'];
            $invDesc = str_replace("{order_id}", $orderId, Yii::t('user', 'Pay for order {order_id} on site gifm.ru'));
            $outSum = $order['price'];
            $SignatureValue = md5($mrhLogin.":".$outSum.":".$order->id.":".$mrhPass1);

            // URL для редиректа на платежную систему с параметрами
            $roboUrl = "https://merchant.roboxchange.com/Index.aspx?MrchLogin=" . $mrhLogin . "&OutSum=" . $outSum . "&InvId=" . $order->id . "&Desc=" . urlencode($invDesc) . "&SignatureValue=" . $SignatureValue . "&IncCurrLabel=" . $IncCurrLabel;
            //$roboUrl = "http://test.robokassa.ru/Index.aspx?MrchLogin=" . $mrhLogin . "&OutSum=" . $outSum . "&InvId=" . $order->id . "&Desc=" . urlencode($invDesc) . "&SignatureValue=" . $SignatureValue . "&IncCurrLabel=" . $IncCurrLabel;

            // Пытаемся найти транзакцию в логах по номеру заказа
            $payment = Logpayment::model()->find('order_id=:order_id',array(':order_id'=>$orderId));

            // Если не нашли транзакцию, создаем новый лог
            if ($payment === null)
            {
                $payment = new Logpayment;
                $payment->user_id = $order->user_id;
                $payment->order_id = $order->id;
                $payment->amount = $order['price'];
                $payment->currency = $order['currency'];
                $payment->in_out = 'IN';
                $payment->pay_system = 'ROBOX';
                $payment->payed_type = 'AUTO';
                $payment->state = 'I';
                $payment->timestamp = new CDbExpression('NOW()');
                $payment->save();

                // Редирект на систему оплаты
                Yii::app()->request->redirect($roboUrl);
            }
            else
            {
                if(in_array($payment->state,array("S")))
                {
                    Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Этот счет уже оплачен. Обратитесь к администратору сайта для решения проблемы (раздел Контакты).");
                }
                else
                {
                    // Редирект на систему оплаты
                    Yii::app()->request->redirect($roboUrl);
                }
            }
        }

        $this->render('create',array('order'=>$order));
    }

    /**
     * Result action
     */
    public function actionResult()
    {
        // Берем логин и пароль из настроек
        $mrhPass2 = Yii::app()->params['rb_pass2'];

        // Получаем данные запроса POST
        $request = Yii::app()->request;
        $outSum = $request->getPost('OutSum');
        $invId = $request->getPost('InvId');
        $crc = $request->getPost('SignatureValue');
        $crc = strtoupper($crc); // принудительно переводим в верхних регистр

        // Собирем собственных хеш
        $my_crc = strtoupper(md5($outSum.":".$invId.":".$mrhPass2));

        // Сравниваем собственных хэш с полученным
        if (strtoupper($my_crc) == strtoupper($crc))
        {
            // Валидация платежа
            $order = Orders::model()->findByPk($invId);

            if ($order !== null)
            {
                // Пополняем баланс пользователя
                $payment = Logpayment::model()->find('order_id=:order_id',array(':order_id'=>$invId));
                if ($payment !== null && $payment->state != 'S')
                {
                    // Обновляем статус платежа в таблице Orders
                    $order->status = 'PAYED';
                    $order->timestamp = new CDbExpression('NOW()');
                    $order->save();

                    // Меняем статус на выполненный в логе
                    $payment->state = 'S';
                    $payment->save();

                    // Отправляем уведомление пользователю об оплате заказа
                    UMail::userSendEmail($order->user_id, 'user_payed_order', array(
                            'order_id'=>$order->id
                        )
                    );

                    // Отправляем уведомление менеджерам об оплате заказа
                    UMail::salesSendEmail('sales_new_order', array(
                            'order_id'=>$order->id
                        )
                    );

                    echo "OK{$invId}\n";
                }
            }
        }
    }

    /**
     * Success message
     */
    public function actionSuccess()
    {
        $order_id = intval(Yii::app()->request->getPost('InvId'));
        Yii::app()->user->setFlash('success', "Вы успешно оплатили Ваш заказ #".$order_id." и он поступил к нам в обработку.<br>Отслеживать статус заказа Вы можете в своем личном кабинете, в разделе Мои заказы или <a href='/order/create/info/id/".$order_id."'>по этой ссылке</a>.");
        $this->render('message');
    }

    /**
     * Fail message
     */
    public function actionFail()
    {
        Yii::app()->user->setFlash('error', "Во время платежа произошла ошибка, пожалуйста повторите платеж!");
        $this->render('message');
    }
}