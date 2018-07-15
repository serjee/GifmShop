<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class MainController extends CController
{
	/**
	 * Страница - Как это работает?.
	 */
	public function actionIndex()
	{
        // Вызываем нужные скрипты
        Yii::app()->clientScript->registerPackage('jquery_validate');
        Yii::app()->clientScript->registerPackage('jquery_ui');
        Yii::app()->clientScript->registerPackage('jquery_ui_datepicker_ru');
        Yii::app()->clientScript->registerPackage('vk_gifts');

        // Рендер отображения
        $this->render('index');
	}

    /**
     * Страница - Подарки.
     */
    public function actionGifts()
    {
        // Вызываем нужные скрипты
        Yii::app()->clientScript->registerPackage('jquery_validate');
        Yii::app()->clientScript->registerPackage('jquery_ui');
        Yii::app()->clientScript->registerPackage('jquery_ui_datepicker_ru');
        Yii::app()->clientScript->registerPackage('vk_gifts');

        // Рендер отображения
        $this->render('gifts');
    }

    /**
     * Страница - Хочу подарить.
     */
    public function actionGive()
    {
        // Вызываем нужные скрипты
        Yii::app()->clientScript->registerPackage('jquery_validate');
        Yii::app()->clientScript->registerPackage('jquery_ui');
        Yii::app()->clientScript->registerPackage('jquery_ui_datepicker_ru');
        Yii::app()->clientScript->registerPackage('vk_gifts');

        // Рендер отображения
        $this->render('give');
    }

    /**
     * Страница - Хочу получить.
     */
    public function actionGet()
    {
        // Вызываем нужные скрипты
        Yii::app()->clientScript->registerPackage('jquery_validate');
        Yii::app()->clientScript->registerPackage('jquery_ui');
        Yii::app()->clientScript->registerPackage('jquery_ui_datepicker_ru');
        Yii::app()->clientScript->registerPackage('vk_gifts');

        // Рендер отображения
        $this->render('get');
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