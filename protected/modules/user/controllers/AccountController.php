<?php

class AccountController extends Controller
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
				'actions'=>array('index','login','registration','recovery','captcha'),
				'users'=>array('*'),
			),
            array('allow',  // allow auth users to perform 'index' actions
				'actions'=>array('logout'),
				'users'=>array('@'),
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
	 * Displays the index page
	 */
    public function actionIndex()
    {
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Если пользователь авторизован, делаем редирект на профиль
        if (Yii::app()->user->id)
        {
            $this->redirect(array("/user/account/profile"));
        }

        // Устанавливаем заголовок станицы
        $this->pageTitle=Yii::t('user', 'Login Registration').' / '.Yii::app()->name ;
        Yii::app()->clientScript->registerPackage('bootstrap');

        // Инициализируем модели
        $model_login = new LoginForm();
        $model_reg = new User('regUser');

        // Ajax валидация формы Авторизации
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model_login);
            Yii::app()->end();
        }

        // Ajax валидация формы Регистрации
        if(isset($_POST['ajax']) && $_POST['ajax']==='reg-form')
        {
            echo CActiveForm::validate($model_reg);
            Yii::app()->end();
        }

        // Проверка данных формы Авторизации
        if(isset($_POST['LoginForm']))
        {
            // Проверяем артибуты формы и в случае успешной валидации, авторизируем
            $model_login->attributes = $_POST['LoginForm'];
            if($model_login->validate() && $model_login->login())
            {
                // Обновляем Время последнего визита и IP
                $uModel = User::model()->findByPk(Yii::app()->user->id);
                $uModel->time_update = new CDbExpression('NOW()');
                $uModel->ip = Yii::app()->request->userHostAddress;
                $uModel->save();

                // Редирект на профиль пользователя после авторизации
                $this->redirect(array("/user/profile"));
            }
        }

        // Проверка данных формы Регистрации
        if(isset($_POST['User']))
        {
            $model_reg->attributes = $_POST['User'];
            $model_reg->verifyCode = $_POST['User']['verifyCode'];
            $model_reg->ip = Yii::app()->request->userHostAddress;

            if($model_reg->validate('regUser'))
            {
                if($model_reg->save())
                {
                    // Создаем новый профиль для нового пользователя
                    $p_model = new Profile('regUser');
                    $p_model->user_id = $model_reg->uid;
                    $p_model->save(false);

                    Yii::app()->user->setFlash('registrationMessage',Yii::t('user', 'Thank you! You are registered successfully!'));
                    $this->redirect(array("/user/account"));
                }
                else
                {
                    $model_reg->addError('email', Yii::t('user', 'Unknow error. Please contact with us by E-mail: {admin_email}', array('{admin_email}'=>Yii::app()->params['adminEmail'])));
                    $this->render("index", array('model' => $model_reg));
                }
            }
            else
            {
                $this->render("index", array('model' => $model_reg));
            }
        }

        // Отображаем форму
        $this->render('index',array('model_login'=>$model_login,'model_reg'=>$model_reg));

    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
        $this->redirect(array("/user/account"));
	}

	/**
	 * Recovery password
	 */
	public function actionRecovery()
    {
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        $this->pageTitle=Yii::t('user', 'Restore Password').' / '.Yii::app()->name;
        Yii::app()->clientScript->registerPackage('bootstrap');
        
        $model = new RecoveryForm;
        
		if (Yii::app()->user->id)
        {
            $this->redirect(array("/user/profile"));
        }
        else
        {
            $email = ((isset($_GET['email']))?$_GET['email']:'');
            $code = ((isset($_GET['code']))?$_GET['code']:'');
            
            if ($email&&$code)
            {
                $model2 = new ChangePassword;
                $find = User::model()->findByAttributes(array('email'=>$email));
                
                if(isset($find)&&$find->salt==$code)
                {
                    $this->pageTitle=Yii::t('user', 'Change Password').' / '.Yii::app()->name;
                    
                    if(isset($_POST['ChangePassword']))
                    {
                        $model2->attributes=$_POST['ChangePassword'];
                        $model2->code=$code;
                        $model2->md5pwd=$find->password;
                        
                        if($model2->validate())
                        {
                            $find->salt = User::model()->generateSalt();
                            $find->password = md5($find->salt.$model2->password);
                            
                            if($find->save())
                            {
                                Yii::app()->user->setFlash('recoveryMessage',Yii::t('user', 'New password is saved'));
                                $this->redirect(array("/user/account/recovery"));
                            }
                            else
                            {
                                Yii::app()->user->setFlash('recoveryMessage',Yii::t('user', 'Unknow error. Please contact with us by E-mail: {admin_email}', array('{admin_email}'=>Yii::app()->params['adminEmail'])));
                                $this->redirect(array("/user/account/recovery"));
                            }
                        }
                    } 
                    $this->render('changepassword',array('model2'=>$model2));
                }
                else
                {
                    Yii::app()->user->setFlash('recoveryMessage',Yii::t('user', 'Incorrect recovery link'));
                    $this->redirect(array("/user/account/recovery"));
                }
            }
            else
            {
                if(isset($_POST['RecoveryForm']))
                {
                    $this->pageTitle=Yii::t('user', 'Restore Password').' / '.Yii::app()->name;
                    
                    $model->attributes=$_POST['RecoveryForm'];
                    
                    if($model->validate())
                    {
                        $user = User::model()->findbyPk($model->user_id);
                        $activation_url = 'http://'.$_SERVER['HTTP_HOST'].$this->createUrl(implode(array("/user/account/recovery")),array("email" => $user->email, "code" => $user->salt));
							
                        $subject = Yii::t('user', 'You have requested the password recovery site {site_name}', array('{site_name}'=>Yii::app()->name,));
                        $message = Yii::t('user', 'You have requested the password recovery site {site_name}. To receive a new password, go to {activation_url}',array('{site_name}'=>Yii::app()->name,'{activation_url}'=>$activation_url,));
                        
                        //get template 'simple' from /themes/default/views/mail
                        $mail = new YiiMailer('simple', array('message'=>$message, 'description'=>Yii::t('user', 'Recovery your password')));
                        //render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')
                        $mail->render();
        				//set properties as usually with PHPMailer
        				$mail->From = Yii::app()->params['adminEmail'];
        				$mail->FromName = Yii::app()->params['fromNameEmail'];
        				$mail->Subject = $subject;
        				$mail->AddAddress($user->email);
        				//send
        				if ($mail->Send())
                        {
        					$mail->ClearAddresses();
        					Yii::app()->user->setFlash('recoveryMessage',Yii::t('user', 'You have requested the password recovery. We will got the message in the near time.'));
        				}
                        else
                        {
        					Yii::app()->user->setFlash('recoveryMessage',Yii::t('user', 'Error while sending email: {error}', array('{error}' => $mail->ErrorInfo)));
        				}
                        $this->refresh();
                    }
                }
                $this->render('recovery',array('model' => $model));
            }
        }
    }
}