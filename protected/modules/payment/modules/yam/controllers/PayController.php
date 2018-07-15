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
				'actions'=>array('order','notify','result','success','fail'),
				'users'=>array('*'),
			),
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

        // Инициализируем модель по номеру заказа
        $order = Orders::model()->find('id=:id AND status=:status', array(':id'=>$orderId,':status'=>'NEW'));

        // Если не найдено, выводим ошибку
        if ($order === null)
        {
            Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Заказ с таким номером не найден или у него изменен статус! Для решения проблемы оформите пожалуйста новый заказ!");
        }
        else
        {
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
                $payment->pay_system = 'YAM';
                $payment->payed_type = 'AUTO';
                $payment->state = 'I';
                $payment->timestamp = new CDbExpression('NOW()');
                $payment->save();
            }
            else
            {
                if(in_array($payment->state,array("S")))
                {
                    Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Этот счет уже оплачен. Обратитесь к администратору сайта для решения проблемы (раздел Контакты).");
                }
            }
        }
        
        // Параметры платежной системы
        $userModel = User::model()->findByPk($order->user_id);
        $uid = '410012058541159'; // Кошелек продавца
        $comment = urlencode ('Оплата заказа #'.$order->id.' от пользователя '.$userModel->email.' в интернет-магазине Gifm.ru'); // Комментарий

        $this->render('create',array('order'=>$order,'uid'=>$uid,'comment'=>$comment));
    }

    /**
     * Result action - create model WmForm, validate it and run success order method
     */
    public function actionResult()
    {
        require_once($_SERVER["DOCUMENT_ROOT"].'/protected/vendors/YamSDK/lib/YandexMoney.php');
        require_once($_SERVER["DOCUMENT_ROOT"].'/protected/vendors/YamSDK/sample/consts.php');

        // Получаем данные запроса POST
        $request = Yii::app()->request;
        $notification_type = $request->getPost('notification_type');
        $operation_id = $request->getPost('operation_id');
        $amount = $request->getPost('amount');
        $currency = $request->getPost('currency');
        $datetime = $request->getPost('datetime');
        $sender = $request->getPost('sender');
        $codepro = $request->getPost('codepro');
        $label = $request->getPost('label');
        $sha1_hash = $request->getPost('sha1_hash');

        // Создаем хэш из параметров запроса
        $post_hash = $notification_type . '&' .
            $operation_id . '&' .
            $amount . '&' .
            $currency . '&' .
            $datetime . '&' .
            $sender . '&' .
            $codepro . '&o1ljMd6qDA4GcEYS+U0s2k0v&' .
            $label;

        // Если счет не защищен протекцией, обрабатываем его автоматически
        if($codepro == 'false')
        {
            // Сравниваем хеши
            if(sha1($post_hash) == $sha1_hash)
            {
                $yandexMoneyAdapter = new YandexMoney(CLIENT_ID);

                $token = '410012058541159.CE6633B7C444639FD2019F3E853B7DE7339E9F20039AC97744991C17500955408B7FBF730EB75CE7FBE724C73F2B05AA8FB4672F5720244ABDC021DD3D93066D851B13BA09C7FB7600E63ACC5A0425CF55800481D7C3225873B70ED994C3F4A45A6E2D66B3ED6380984D023C147EB36370D09F691A54679C81D8D0F2F6D365D1';
                $resp = $yandexMoneyAdapter->operationDetail($token, $operation_id);

                // Получаем ответ от сервера
                if($resp->isSuccess())
                {
                    // Вытаскиваем номер счета из комментария платежа
                    preg_match('/#(\d+)\s/', $resp->getMessage(), $m);
                    $bill_id = intval($m[1]);

                    // Если счет существует
                    if($bill_id > 0)
                    {
                        // Вызов модуля
                        Yii::app()->getModule('order');

                        // Валидация платежа
                        $order = Orders::model()->findByPk($bill_id);

                        if ($order !== null)
                        {
                            // Вытаскиваем сумму
                            $yam_amount = round($amount+($order->price*0.005)); // Яндекс возвращает минус комиссия. Добавляем ее для сверки

                            if ($yam_amount==$order->price)
                            {
                                // Пополняем баланс пользователя
                                $payment = Logpayment::model()->find('order_id=:order_id',array(':order_id'=>$bill_id));
                                if ($payment !== null && $payment->state != 'S')
                                {
                                    // Обновляем статус платежа в таблице Orders
                                    $order->status = 'PAYED';
                                    $order->timestamp = new CDbExpression('NOW()');
                                    $order->save();

                                    // Меняем статус на выполненный в логе
                                    $payment->lmi_payer_purse = $sender;
                                    $payment->lmi_sys_payment_id = $operation_id;
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
                                }
                            }
                        }
                    }
                }
            }
        }
    }

	/**
	* Success message
	*/
	public function actionSuccess()
    {
        Yii::app()->user->setFlash('success', "Вы успешно оплатили Ваш заказ #".intval(Yii::app()->request->getQuery('order')));
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
