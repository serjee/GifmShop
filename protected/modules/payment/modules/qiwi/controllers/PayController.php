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
				'actions'=>array('order','notify','success','fail'),
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
        // Инициализируем модель формы
        $model = new QiwiForm();

        // Если ввели телефон и нажали "выставить счет"
        if(isset($_POST['QiwiForm']))
        {
            $request = Yii::app()->request->getPost('QiwiForm');
            $model->phone = $request['phone'];
            $model->order_id = intval($request['order_id']);
            if($model->validate())
            {
                // Вытаскиваем данные о заказе
                $order = Orders::model()->find('id=:id AND status=:status', array(':id'=>$model->order_id,':status'=>'NEW'));

                if ($order === null)
                {
                    Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Заказ с таким номером не найден или у него изменен статус! Для решения проблемы оформите пожалуйста новый заказ!");
                }
                else
                {
                    // Проверка статуса оформления заказа
                    $payment = Logpayment::model()->find('order_id=:order_id',array(':order_id'=>$model->order_id));
                    if ($payment !== null)
                    {
                        if($payment->state == 'R') // Счет уже выставлен
                        {
                            Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Счет по данному заказу уже выставлен в системе QiwiWallet. Пожалуйста, войдите в ваш аккаунт на QiwiWallet и оплатите выставленный счет.");
                        }
                        elseif($payment->state == 'S') // Счет выставлен и уже оплачен
                        {
                            Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Счет по данному заказу уже оплачен.");
                        }
                        else // Пытаемся выставить счет
                        {
                            // Вытаскиваем информацию о E-mail
                            $userModel = User::model()->findByPk($order->user_id);
                            $userName = $userModel->email;
                            $qiwiComment = 'Пополнение по счету №'.$model->order_id.' от пользователя '.$userName.' в DomCentre.com';
        
                            // Выставляем счет пользователю
                            $qiwi = new QiwiClass();
                            $qiwiResult = $qiwi->createBill($model->order_id,$model->phone,$order['amount'].'.00','RUB',$qiwiComment);
        
                            // Если счет выставлен успешно
                            if($qiwiResult->response->result_code == '0')
                            {
                                // Устанавливаем сообщение
                                Yii::app()->user->setFlash('success', "<strong>Выполнено!</strong> На указанный вами номер телефона выставлен счет! Пожалуйста, войдите в свой личный кабинет на сайте Qiwi Wallet и оплатите его.");
        
                                // Обновляем информацию о заказе в таблице логов
                                $payment->state = 'R';
                                $payment->timestamp = new CDbExpression('NOW()');
                                $payment->save();

                                // Редирект на страницу оплаты
                                $this->redirect('https://w.qiwi.com/order/external/main.action?shop=240964&transaction='.$model->order_id);
                            }
                            else
                            {
                                Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Не удалось выставить счет на указанный номер ( ".$qiwiResult->response->description." )! Пожалуйста, повторите оплату.");
                            }
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Вернитесь на страницу ввода номера телефона для выставления счета в системе QiwiWallet.");
                    }
                }
            }
        }
        else
        {
            // Получаем номер заказа из $_GET
            $orderId = intval(Yii::app()->request->getQuery('id'));

            // Инициализируем модель по номеру заказа
            $order = Orders::model()->find('id=:id AND status=:status', array(':id'=>$orderId,':status'=>'NEW'));

            // Если не найдено, выводим ошибку
            if ($order === null)
            {
                Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Заказ с таким номером не найдено в базе или он уже оплачен!");
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
                    $payment->pay_system = 'QIWI';
                    $payment->payed_type = 'AUTO';
                    $payment->state = 'I';
                    $payment->timestamp = new CDbExpression('NOW()');
                    $payment->save();
                }
                else
                {
                    if(in_array($payment->state,array("R","S")))
                    {
                        Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Счет по этому заказу уже выставлен или оплачен! Пожалуйста, вернитесь назад в панель управления и попробуйте пополнить баланс заново.");
                    }
                }
            }
        }

        $this->render('create',array('model'=>$model,'order'=>$order,));
    }

    /**
     * Result action - create model WmForm, validate it and run success order method
     */
    public function actionNotify()
    {
        $fp = @fopen("/home/user/www/domcentre.com/mylog.txt", "a+");
        @fwrite($fp, "[".date("Y-m-d H:i:s")."] 0.Notify.\r\n");
        
        // Используем Basic авторизацию для получения уведомлений
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) 
        {
            $username=$_SERVER['PHP_AUTH_USER'];
            $password=$_SERVER['PHP_AUTH_PW'];
            
            // Инициализируем объект для получения параметров доступа
            $qiwi = new QiwiClass();

            @fwrite($fp, "[".date("Y-m-d H:i:s")."] 1.PreAuth.\r\n");
            
            // Проверяем доступ
            if($qiwi->getLogin()==$username && $qiwi->getPasswd()==$password)
            {
                @fwrite($fp, "[".date("Y-m-d H:i:s")."] 2.CheckAuth.\r\n");
                
                // Получаем параметры POST-запроса
                // bill_id=BILL-1&status=paid&error=0&amount=1.00&user=tel%3A%2B79031811737
                $request = Yii::app()->request;
                $bill_id = intval($request->getPost('bill_id'));
                $bill_status = $request->getPost('status');
                $bill_error = $request->getPost('error');
                $bill_amount = $request->getPost('amount');
                //$bill_user = urldecode($request->getPost('user'));
                //$bill_user = str_replace("tel:", "", $bill_user);
                
                // Валидация платежа
                $order = Rp4Accounts::model()->findByPk($bill_id);
                if ($order === null)
                {
                    // Возвращаем ошибку (заказ не найден)
                    $result_code = 100;
                }
                else
                {
                    @fwrite($fp, "[".date("Y-m-d H:i:s")."] 3.OrderCheck.\r\n");
                    @fwrite($fp, "[".date("Y-m-d H:i:s")."] ".$bill_status."|".$bill_error."|".$bill_amount."|".$order->amount.".\r\n");
                   
                    // Проверяем параметры платежа
                    if($bill_status=='paid' && $bill_error==0)
                    {
                        @fwrite($fp, "[".date("Y-m-d H:i:s")."] 4.CheckBill.\r\n");
                        
                        // Пополняем баланс пользователя
                        $payment = Logpayment::model()->find('order_id=:order_id',array(':order_id'=>$bill_id));
                        
                        // Если не нашли транзакцию, устанавливаем ошибку
                        if ($payment === null)
                        {
                            $result_code = '120';
                        }
                        else
                        {
                            @fwrite($fp, "[".date("Y-m-d H:i:s")."] 5.Logpayment.\r\n");
                            
                            // Устанавливаем код "Успешно"
                            $result_code = '0';
                            
                            // Если платеж не был оплачен до этого, то зачисляем деньги пользователю
                            if ($payment->state != 'S')
                            {
                                // Пишем логи в таблицу rp4_balance_log
                                //(21, 1, 100, 'in', 29, '2013-09-23 12:54:10', 'NAL', '', 'manual');
                                $rp4balancelogModel = new Rp4BalanceLog();
                                $rp4balancelogModel->user_id = $order->user_id;
                                $rp4balancelogModel->amount = intval($order->amount);
                                $rp4balancelogModel->in_out = 'in';
                                $rp4balancelogModel->account_order_num = $order->id;
                                $rp4balancelogModel->timestamp = new CDbExpression('NOW()');
                                $rp4balancelogModel->pay_system = 'QIWI';
                                // Сохраняем данные в таблице
                                $rp4balancelogModel->save();
            
                                // Вносим изменения баланса для пользователя в таблицу rp4_users
                                $rp4userModel = Rp4Users::model()->findByPk($order->user_id);
                                $rp4userModel->balance += $order->amount;
                                $rp4userModel->save();
            
                                // Обновляем статус платежа в таблице rp4_accounts
                                $order->payed = '1';
                                $order->payed_date = new CDbExpression('NOW()');
                                $order->save();
            
                                // Меняем статус на выполненный в логе
                                $payment->state = 'S';
                                $payment->save();
                            }
                        }
                    }
                    else
                    {
                        $result_code = '110';
                    }
                }
        
                // Отдаем XML со статусом платежа
                header('Content-type: text/xml');
                $this->renderPartial('output_xml', array('result_code'=>$result_code));
            }
            else
            {
                header("WWW-Authenticate: Basic realm=\"Authentication needed\"");  
                throw new CHttpException(401,Yii::t('yii','You are not authorized to perform this action.'));
            }
        }
        else
        {
            @fwrite($fp, "[".date("Y-m-d H:i:s")."] 1.AuthWrong : ".$_SERVER['PHP_AUTH_USER']." : ".$_SERVER['PHP_AUTH_PW'].".\r\n");
            
            header("WWW-Authenticate: Basic realm=\"Authentication needed\"");  
            throw new CHttpException(401,Yii::t('yii','You are not authorized to perform this action.'));
        }

        @fclose($fp);
    }

	/**
	* Success message
	*/
	public function actionSuccess()
    {
        Yii::app()->user->setFlash('success', "Вы успешно оплатили Ваш заказ №".intval(Yii::app()->request->getQuery('order')));
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
