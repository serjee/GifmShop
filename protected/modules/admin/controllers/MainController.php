<?php

class MainController extends AdminController
{
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
			array('allow',   // allow ADMIN users to perform 'index' actions
				'actions'=>array('index','view','update'),
				'roles'=>array('ADMIN'),
			),
			array('deny',    // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    /**
	 * Manages last news models.
	 */
    public function actionIndex()
    {
        // Принудительный вызов модуля заказов
        Yii::app()->getModule('order');

        $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('admin', 'Orders Management');

        $model = new Orders('search');
        $model->unsetAttributes();    // clear any default values

        if(isset($_GET['Orders']))
            $model->attributes=$_GET['Orders'];

        $this->render('index',array('model'=>$model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
    public function actionView($id)
    {
        // Устанавливаем заголовок
        $this->pageTitle=Yii::t('admin', 'View order info').' / '.Yii::app()->name;

        // Принудительный вызов модулей
        Yii::app()->getModule('order');
        Yii::app()->getModule('user');

        // Загружаем модель Заказов
        $modelOrders = $this->loadModel($id);

        // Загружаем модель Пользователя
        $modelUser = User::model()->findByPk($modelOrders->user_id);
        if($modelUser===null)
            throw new CHttpException(404,Yii::t('admin', 'The requested page does not exist'));

        // Загружаем модель профиля Доставки
        $modelDelivery = OrdersDelivery::model()->findByPk($modelOrders->profile_id);
        if($modelDelivery===null)
            throw new CHttpException(404,Yii::t('admin', 'The requested page does not exist'));

        // Рендер
        $this->render('view',array(
            'modelOrders'=>$modelOrders,
            'modelUser'=>$modelUser,
            'modelDelivery'=>$modelDelivery,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        // Устанавливаем заголовок
        $this->pageTitle=Yii::t('admin', 'Edit user').' / '.Yii::app()->name;

        // Принудительный вызов модулей
        Yii::app()->getModule('order');
        Yii::app()->getModule('user');

        // Загружаем модель Заказов
        $modelOrders = $this->loadModel($id);

        // Загружаем модель профиля Доставки
        $modelDelivery = OrdersDelivery::model()->findByPk($modelOrders->profile_id);
        if($modelDelivery===null)
            throw new CHttpException(404,Yii::t('admin', 'The requested page does not exist'));

        // AJAX валидация Заказов
        $this->performAjaxValidation($modelOrders);

        // AJAX валидация Доставки
        $this->performAjaxValidation($modelOrders);

        // Сохраняем параметры заказа
        if(isset($_POST['Orders']))
        {
            $modelOrders->attributes = $_POST['Orders'];
            if($modelOrders->save())
            {
                Yii::app()->user->setFlash('updateOrder',Yii::t('admin', 'The order has been edited successfully!'));
                $this->redirect(array("/admin/main/view/id/".$id));
            }
            else
            {
                $modelOrders->addError('id', Yii::t('admin', 'Unknow error'));
            }
        }

        // Сохраняем параметры доставки
        if(isset($_POST['OrdersDelivery']))
        {
            $modelDelivery->attributes = $_POST['OrdersDelivery'];
            if($modelDelivery->save())
            {
                Yii::app()->user->setFlash('updateAdress',Yii::t('admin', 'The order has been edited successfully!'));
                $this->redirect(array("/admin/main/view/id/".$id));
            }
            else
            {
                $modelDelivery->addError('zip_code', Yii::t('admin', 'Unknow error'));
            }
        }

        // Рендер
        $this->render('update',array('modelOrders'=>$modelOrders,'modelDelivery'=>$modelDelivery));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @return
     * @internal param \the $integer ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Orders::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,Yii::t('admin', 'The requested page does not exist'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}