<?php

class OrderController extends Controller
{
	public function actionIndex()
	{
        // устанавливаем заголовок страницы
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Project description');
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('bootstrap');

        // Получаем ID заказа из POST
        $InvId = intval(Yii::app()->request->getPost('InvId'));

        $model = new OrderForm();

        // Шаг 2. Пользователь выбрал платежную систему
        if(isset($_POST['OrderForm']))
        {
            $request = Yii::app()->request->getPost('OrderForm');

            $ordersModel = Orders::model()->find('id=:id AND status=:status', array(':id'=>$request['order_id'],':status'=>'NEW'));
            if($ordersModel===null)
            {
                // Ошибка - не найден заказ
                Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Заказ с таким номером не найден или у него изменен статус! Для решения проблемы оформите пожалуйста новый заказ!");
            }
            else
            {
                // Вытаскиваем информацию о заказе из таблицы Orders
                $model->order_id = $ordersModel->id;
                $model->amount = $ordersModel->price;
                $model->IncCurrLabel = $request['IncCurrLabel'];
                $model->paysys = $request['paysys'];

                if($model->validate())
                {
                    switch($request['paysys'])
                    {
                        case "WMR":
                            $this->redirect(array('/payment/webmoney/pay/order','id'=>$model->order_id));
                            break;
                        //case "WMZ":
                            //$this->redirect(array('/payment/webmoney/pay/order','id'=>$model->order_id,'s'=>'wmz'));
                            //break;
                        case "QIWI":
                            $this->redirect(array('/payment/qiwi/pay/order','id'=>$model->order_id));
                            break;
                        case "YAM":
                            $this->redirect(array('/payment/yam/pay/order','id'=>$model->order_id));
                            break;
                        case "PAYPAL":
                            $this->redirect(array('/payment/paypal/pay/order','id'=>$model->order_id));
                            break;
                        case "ROBOX":
                            $this->redirect(array('/payment/rb/pay/order','id'=>$model->order_id,'icl'=>$model->IncCurrLabel));
                            break;
                    }
                }
                else
                {
                    // Ошибка валидации
                    Yii::app()->user->setFlash('error', $model->getErrors());
                }
            }
        }
        elseif(!isset($_POST['InvId']))
        {
            // Ошибка что не переданы параметры
            Yii::app()->user->setFlash('error', "<strong>Ошибка!</strong> Не переданы параметры заказа!");
        }

        // Отображение страницы выбора систем оплаты
        $this->render('index', array(
            'model'=>$model,
            'InvId'=>$InvId,
        ));
	}
}