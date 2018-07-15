<?php

class TransactionController extends AdminController
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
            array('allow',   // allow admin users to perform 'delete','create','update','index' actions
                'actions'=>array('index'),
                'roles'=>array('ADMIN'),
            ),
            array('deny',    // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        // Принудительный вызов модуля заказов
        Yii::app()->getModule('order');

        $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('admin', 'Orders Management');

        $model = new Logpayment('search');
        $model->unsetAttributes();    // clear any default values

        if(isset($_GET['Logpayment']))
            $model->attributes=$_GET['Logpayment'];

        $this->render('index',array('model'=>$model));
    }
}