<?php

class ProfileController extends Controller
{
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
            'ajaxOnly + getaddressinfo',
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
            array('allow',  // allow auth users to perform 'index' actions
				'actions'=>array('index','edit','changepassword','deletephoto','delivaddress','getaddressinfo','myorders'),
				'users'=>array('@'),
			),
			array('deny',    // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    /**
	 * Displays the index page
	 */
    public function actionIndex()
    {
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

	    $this->pageTitle=Yii::t('user','My profile').' / '.Yii::app()->name;
        
        $this->render('index',array('model'=>$this->loadUserModel(),));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @internal param int $id the ID of the model to be updated
     */
	public function actionEdit()
	{
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        $this->pageTitle=Yii::t('user', 'Edit Profile').' / '.Yii::app()->name;
        Yii::app()->clientScript->registerPackage('bootstrap');
        
		$model=$this->loadUserModel();

		// AJAX validation
		$this->performAjaxValidation($model);

		if(isset($_POST['Profile']))
		{
			$model->attributes=$_POST['Profile'];
            
			if($model->save())
            {
                Yii::app()->user->setFlash('editMessage',Yii::t('user', 'Your profile has been successful updated!'));
                $this->redirect(array('/user/profile'));
            }				
		}
		$this->render('edit',array('model'=>$model,));
	}
    
	/**
	 * Change password
	 */
	public function actionChangepassword()
    {
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        $this->pageTitle=Yii::t('user', 'Change Password').' / '.Yii::app()->name;
        Yii::app()->clientScript->registerPackage('bootstrap');
        
		$model = new ChangePassword;
        
		if (Yii::app()->user->id)
        {
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepwd-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['ChangePassword']))
            {
                $new_password = User::model()->findbyPk(Yii::app()->user->id);
                
                $model->attributes=$_POST['ChangePassword'];
                $model->code=$new_password->salt;
                $model->md5pwd=$new_password->password;
                
				if($model->validate())
                {
                    $new_password->salt=$new_password->generateSalt();                    
					$new_password->password = md5($new_password->salt.$model->password);					
					
                    if($new_password->save())
                    {
                        Yii::app()->user->setFlash('editMessage',Yii::t('user', 'New password is saved'));
                        $this->redirect(array("/user/profile"));
                    }
                    else
                    {
                        $model->addError('oldPassword', Yii::t('user', 'Unknow error. Please contact with us by E-mail: {admin_email}', array('{admin_email}'=>Yii::app()->params['adminEmail'])));
                        $this->render("changepassword", array('model2' => $model));
                    }					
				}
			}
			$this->render('changepassword',array('model2'=>$model));
	    }
	}

    /**
     * Профили адресов доставки
     */
    public function actionDelivaddress()
    {
        // Принудительный вызов модуля заказов
        Yii::app()->getModule('order');

        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Устанавливаем заголовки и подгружаем скрипт
        $this->pageTitle=Yii::t('user', 'Delivery address').' / '.Yii::app()->name;
        Yii::app()->clientScript->registerPackage('bootstrap');

        // Создаем объект модели
        $model = new OrdersAddress();

        // Проверяем ID профиля (новый или редактирование)
        $request = Yii::app()->request->getPost('OrdersAddress');
        $address_id = intval($request['id']);
        if($address_id > 0)
        {
            $model = OrdersAddress::model()->find('id=:id AND user_id=:user_id', array(':id'=>$address_id,':user_id'=>Yii::app()->user->id));
            // Если модель не найдена
            if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }

        // ajax валидатор формы
        if(isset($_POST['ajax']) && $_POST['ajax']==='address-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // Обрабатываем данные формы (создаем/редактируем)
        if(isset($_POST['OrdersAddress']))
        {
            $model->user_id = Yii::app()->user->id;
            $model->zip_code = $request['zip_code'];
            $model->country_id = $request['country_id'];
            $model->city = $request['city'];
            $model->address = $request['address'];
            $model->recipient = $request['recipient'];
            $model->comments = $request['comments'];
            $model->timestamp = new CDbExpression('NOW()');

            if($model->save())
            {
                Yii::app()->user->setFlash('editMessage',Yii::t('user', 'New delivery address has been added!'));
            }
            else
            {
                Yii::app()->user->setFlash('errorMessage',Yii::t('user', 'New delivery address has not been added!'));
            }
        }

        // Рендер
        $this->render('delivaddress',array('model'=>$model));
    }

    public function actionMyorders()
    {
        // Принудительный вызов модуля заказов
        Yii::app()->getModule('order');

        // Устанавливаем заголовки и подгружаем скрипт
        $this->pageTitle=Yii::t('user', 'My orders').' / '.Yii::app()->name;
        Yii::app()->clientScript->registerPackage('bootstrap');

        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Модель заказов
        $model = new Orders('search');

        // сброс значение модели по умолчанию
        $model->unsetAttributes();

        // для работы фильтра, задаваемого пользователем
        if(isset($_GET['Orders'])) $model->attributes=$_GET['Orders'];

        // Задаем свои условия фильтрации
        $model->user_id = Yii::app()->user->id;

        // Рендер
        $this->render('myorders',array('model'=>$model));
    }
    
	/**
	 * Change password
	 */
	public function actionDeletephoto()
    {
        if (Yii::app()->user->id)
        {
            $model=$this->loadUserModel();
            $model->scenario="deletePhoto"; // see action for delete in SImageUploadBehavior
            if($model->save())
            {
                Yii::app()->user->setFlash('editMessage',Yii::t('user', 'Your image has been delted successfuly!'));
                $this->redirect(array("/user/profile/edit"));
            }
            else
            {
                $model->addError('uimage', Yii::t('user', 'Error while delete image'));
                $this->render('edit',array('model'=>$model,));
            }
        }
    }

    /**
     * Ajax запрос для получения информации о получателях (для доставки)
     */
    public function actionGetaddressinfo()
    {
        // Принудительный вызов модуля заказов
        Yii::app()->getModule('order');

        if(Yii::app()->request->isAjaxRequest)
        {
            $profile_id = intval(Yii::app()->request->getPost('profile_id'));
            if ($profile_id > 0)
            {
                $model = OrdersAddress::model()->findByPk($profile_id);
                if($model!==null)
                {
                    $array_profile = array(
                        'zip_code'=>$model->zip_code,
                        'country_id'=>$model->country_id,
                        'city'=>$model->city,
                        'address'=>$model->address,
                        'comments'=>$model->comments,
                        'recipient'=>$model->recipient,
                    );
                    echo CJSON::encode($array_profile);
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @throws CHttpException
     * @internal param int $id the ID of the model to be loaded
     * @return Profile the loaded model
     */
	public function loadUserModel()
	{
		$model=Profile::model()->findByPk(Yii::app()->user->id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
	/**
	 * Performs the AJAX validation.
	 * @param Profile $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}