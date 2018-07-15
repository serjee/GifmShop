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
        $orderId = intval(Yii::app()->request->getQuery('id'));
        //$paySys = strtoupper(Yii::app()->request->getQuery('s'));
        $paySys = 'WMR';

        if ($orderId > 0 && ($paySys == 'WMR' || $paySys == 'WMZ'))
        {
            $order = Orders::model()->find('id=:id AND status=:status', array(':id'=>$orderId,':status'=>'NEW'));

            if ($order === null)
            {
                Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Заказ с таким номером не найден или у него изменен статус! Для решения проблемы оформите пожалуйста новый заказ!");
            }
            else
            {
                // Пытаемся найти транзакцию в логах по номеру заказа
                $payment = Logpayment::model()->count('order_id=:order_id',array(':order_id'=>$orderId));

                // Если не нашли транзакцию, создаем новый лог
                if(!$payment)
                {
                    $payment = new Logpayment;
                    $payment->user_id = $order->user_id;
                    $payment->order_id = $orderId;
                    $payment->amount = $order['price'];
                    $payment->currency = $order['currency'];
                    $payment->in_out = 'IN';
                    $payment->pay_system = $paySys;
                    $payment->payed_type = 'AUTO';
                    $payment->state = 'I';
                    $payment->timestamp = new CDbExpression('NOW()');
                    $payment->save();
                }
            }
        }
        else
        {
            Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Переданы неверные параметры заказа!");
        }

        $this->render('create',array('order'=>$order,'paySys'=>$paySys));
    }

    /**
     * Result action - create model WmForm, validate it and run success order method
     */
    public function actionResult()
    {
        $request = Yii::app()->request;

        $wmForm = new WmForm();
        $wmForm->LMI_PAYEE_PURSE = $request->getPost('LMI_PAYEE_PURSE');
        $wmForm->LMI_PAYMENT_AMOUNT = $request->getPost('LMI_PAYMENT_AMOUNT');
        $wmForm->LMI_PAYMENT_NO = $request->getPost('LMI_PAYMENT_NO');
        $wmForm->LMI_MODE = $request->getPost('LMI_MODE');
        $wmForm->LMI_PAYER_PURSE = $request->getPost('LMI_PAYER_PURSE');
        $wmForm->LMI_PAYER_WM = $request->getPost('LMI_PAYER_WM');

        // Обработка пререквеста и выполнение платежа
        if($request->getPost('LMI_PREREQUEST') == 1)
        {
            try
            {
                if($wmForm->validate())
                {
                    // Вытаскиваем параметры платежа
                    $payment = Logpayment::model()->find('order_id=:order_id AND state=:state', array(':order_id'=>$wmForm->LMI_PAYMENT_NO,':state'=>'I'));
                    if ($payment !== null)
                    {
                        // Обновляем статус платежа
                        $payment->state = 'P';
                        $payment->lmi_payer_purse = $wmForm->LMI_PAYER_PURSE;
                        $payment->lmi_payer_wm = $wmForm->LMI_PAYER_WM;
                        $payment->save();
                        exit('YES');
                    }
                    else
                    {
                        exit('Заказ с данным ID не найден в базе данных.');
                    }
                }
                else
                {
                    exit(CHtml::errorSummary($wmForm));
                }
            }
            catch (Exception $e)
            {
                exit($e->getMessage());
            }
        }
        else
        {
            try
            {
                $wmForm->scenario = 'paydone';

                $wmForm->LMI_SYS_INVS_NO = $request->getPost('LMI_SYS_INVS_NO');
                $wmForm->LMI_SYS_TRANS_NO = $request->getPost('LMI_SYS_TRANS_NO');
                $wmForm->LMI_SYS_TRANS_DATE = $request->getPost('LMI_SYS_TRANS_DATE');
                $wmForm->LMI_SECRET_KEY = $request->getPost('LMI_SECRET_KEY');
                $wmForm->LMI_HASH = $request->getPost('LMI_HASH');

                if($wmForm->validate())
                {
                    // Вытаскиваем параметры платежа
                    $payment = Logpayment::model()->find('order_id=:order_id AND state=:state', array(':order_id'=>$wmForm->LMI_PAYMENT_NO,':state'=>'P'));
                    if ($payment !== null)
                    {
                        // Обновляем статус платежа
                        $payment->state = 'R';
                        $payment->lmi_sys_invs_no = $wmForm->LMI_SYS_INVS_NO;
                        $payment->lmi_sys_trans_no = $wmForm->LMI_SYS_TRANS_NO;
                        $payment->lmi_sys_trans_date = $wmForm->LMI_SYS_TRANS_DATE;
                        $payment->save();
                        exit('YES');
                    }
                    else
                    {
                        exit('Заказ с данным ID не найден в базе данных.');
                    }
                }
                else
                {
                    exit(CHtml::errorSummary($wmForm));
                }
            }
            catch (Exception $e)
            {
                exit($e->getMessage());
            }
        }
    }

	/**
	* Success message
	*/
	public function actionSuccess()
    {
        $this->setPayStatus(true);

        Yii::app()->user->setFlash('success', "Вы успешно оплатили Ваш заказ №".intval(Yii::app()->request->getPost('LMI_PAYMENT_NO')));
        $this->render('message');
	}

	/**
	* Fail message
	*/
	public function actionFail()
    {
        $this->setPayStatus(false);

        Yii::app()->user->setFlash('error', "Во время платежа произошла ошибка, пожалуйста повторите платеж!");
        $this->render('message');
	}

    /**
     * Устанавливает статус платежа в базе данных
     * @param bool $success
     */
    private function setPayStatus($success = false)
    {
        $request = Yii::app()->request;

        // Вытаскиваем параметры платежа
        $criteria = new CDbCriteria;
        $criteria->condition='order_id=:order_id AND state=:state AND lmi_sys_invs_no=:lmi_sys_invs_no AND lmi_sys_trans_no=:lmi_sys_trans_no';
        $criteria->params=array(
            ':order_id' => $request->getPost('LMI_PAYMENT_NO'),
            ':state' => 'R',
            ':lmi_sys_invs_no' => $request->getPost('LMI_SYS_INVS_NO'),
            ':lmi_sys_trans_no' => $request->getPost('LMI_SYS_TRANS_NO')
        );
        $payment = Logpayment::model()->find($criteria);

        if ($payment !== null)
        {
            if ($success)
            {
                $order = Orders::model()->findByPk(intval($request->getPost('LMI_PAYMENT_NO')));
                if ($order !== null)
                {
                    // Обновляем статус платежа в таблице yii_orders
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
                }
                else
                {
                    $payment->state = 'F';
                    $payment->save();
                }
            }
            else
            {
                $payment->state = 'F';
                $payment->save();
            }
        }
    }
}
