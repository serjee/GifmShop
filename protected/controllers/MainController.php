<?php

class MainController extends Controller
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
            array('allow',  // allow auth users to perform 'index','login' actions
                'actions'=>array('index','delivery','reviews','contacts','error','captcha'),
                'users'=>array('*'),
            ),
            array('deny',    // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the registration page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFF8F8, //цвет фона
                'minLength' => 5,
                'maxLength' => 6,
                'testLimit' => 2,
                'width' => 160,
                'height' => 60,
                'transparent'=>false,
                'foreColor'=>0xd51d13, //цвет символов
            ),
        );
    }

	/**
	 * Экшен главной страницы
	 */
	public function actionIndex()
	{
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

	    // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Project description');

        // Подключаем скрипты бутстрапа
        Yii::app()->clientScript->registerPackage('bootstrap');
        Yii::app()->clientScript->registerPackage('elastislide');

        // Рендер отображения
		$this->render('index');
	}

    /**
     * Эшкен страницы "Доставка и оплата"
     */
    public function actionDelivery()
    {
        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Delivery');

        // Рендер отображения
        $this->render('delivery');
    }

    /**
     * Экшен страницы "Отзывы"
     */
    public function actionReviews()
    {
        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Reviews');

        // Рендер отображения
        $this->render('reviews');
    }

    /**
     * Экшен страницы "Контакты"
     */
    public function actionContacts()
    {
        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Contacts');

        //
        $model = new ContactForm;

        if(isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if($model->validate())
            {
                $headers="From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }

        // Рендер отображения
        $this->render('contacts',array('model'=>$model));
    }

	/**
	 * Экшен страницы ошибки
	 */
	public function actionError()
	{	   
		if($error=Yii::app()->errorHandler->error)
		{
            // view page title
            $this->pageTitle=Yii::t('user', 'Error').' / '.Yii::app()->name;
            
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}