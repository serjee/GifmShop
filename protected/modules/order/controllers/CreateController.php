<?php

class CreateController extends Controller
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
                'actions'=>array('index','step1','step2','step3','info'),
                'roles'=>array('ADMIN'),
            ),
            //array('deny',    // deny all users
            //    'users'=>array('*'),
            //),
        );
    }

    /**
     * Экшен индексной страницы оформления заказа (перебрасываем на 1-ый шаг)
     */
	public function actionIndex()
	{
        $this->redirect(Yii::app()->createUrl('/order/create/step1'));
	}

    /**
     * Экшен страницы 1-го шага оформления заказа
     */
    public function actionStep1()
    {
        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Step 1');

        // Подключаем скрипты бутстрапа
        Yii::app()->clientScript->registerPackage('bootstrap');

        // Создаем модель формы Шага 1
        $modelForm = new Step1Form();

        // Ajax проверка на ошибки
        if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
        {
            echo CActiveForm::validate($modelForm);
            Yii::app()->end();
        }

        // Обработка POST запроса (сохранение данных 1-го шага)
        if(isset($_POST['Step1Form']))
        {
            // Заносим данные в модель из POST
            $modelForm->attributes = $_POST['Step1Form'];

            // Определяем цену по ID, либо устанавливаем в 1 рубль (когда пользователь выбирает бесплатный подарок)
            if($modelForm->price > 0)
            {
                $price_model = Prices::model()->findByPk(intval($modelForm->price));
                $order_price = $price_model->price_ru;
            }
            else
            {
                $order_price = '1.00';
            }

            // Производим валидацию модели формы
            if($modelForm->validate())
            {
                $modelOrdersTemp = new OrdersTemp();
                $modelOrdersTemp->step_num = '1';
                $modelOrdersTemp->order_hash = md5(uniqid(rand(),1));
                //TODO: Для ввода второй и далее валюты придумать условия + автоконвертацию в другие валюты в таблице Prices
                $modelOrdersTemp->price = $order_price;
                $modelOrdersTemp->currency = 'RUB';
                $modelOrdersTemp->category_id = $modelForm->category_id;
                $modelOrdersTemp->whom = $modelForm->whom;
                $modelOrdersTemp->age = $modelForm->age;
                $modelOrdersTemp->hobbies = $modelForm->hobbies;
                $modelOrdersTemp->about = $modelForm->about;
                $modelOrdersTemp->message = $modelForm->message;
                $modelOrdersTemp->prize_from = $modelForm->prize_from;
                $modelOrdersTemp->timestamp = new CDbExpression('NOW()');

                // Сохраняем результаты 1-го шага без проверки (т.к. проверка прошла через модель формы выше)
                if($modelOrdersTemp->save(false))
                {
                    // Сохраняем данные в сессию для 2-го шага
                    Yii::app()->user->setState('temp_order_id', $modelOrdersTemp->id);
                    Yii::app()->user->setState('temp_order_hash', $modelOrdersTemp->order_hash);

                    // Редирект на 2-ой шаг
                    $this->redirect(Yii::app()->createUrl('/order/create/step2'));
                }
            }
        }

        // Рендер формы
        $this->render('step1',array('model'=>$modelForm));
    }

    /**
     * Экшен страницы 2-го шага оформления заказа
     */
    public function actionStep2()
    {
        // Если не установлен id заказа, перекидываем на шаг 1
        if (Yii::app()->user->getState('temp_order_id') < 1)
            $this->redirect(Yii::app()->createUrl('/order/create/step1'));

        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Step 2');

        // Подключаем скрипты бутстрапа
        Yii::app()->clientScript->registerPackage('bootstrap');

        // Создаем модель формы Шага 2
        $modelForm = new Step2Form();

        // Ajax проверка на ошибки
        if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
        {
            echo CActiveForm::validate($modelForm);
            Yii::app()->end();
        }

        // Обработка POST запроса (сохранение данных 1-го шага)
        if(isset($_POST['Step2Form']))
        {
            $modelForm->attributes = $_POST['Step2Form'];
            if($modelForm->validate())
            {
                // Проверку не наличие не делаем, так как она прошла выше в валидации
                $modelOrdersTemp = OrdersTemp::model()->findByPk($modelForm->order_id);
                $modelOrdersTemp->profile_id = $modelForm->id;
                $modelOrdersTemp->step_num = '2';
                $modelOrdersTemp->zip_code = $modelForm->zip_code;
                $modelOrdersTemp->country_id = $modelForm->country_id;
                $modelOrdersTemp->city = $modelForm->city;
                $modelOrdersTemp->address = $modelForm->address;
                $modelOrdersTemp->comments = $modelForm->comments;
                $modelOrdersTemp->recipient = $modelForm->recipient;
                $modelOrdersTemp->timestamp = new CDbExpression('NOW()');

                // Сохраняем результаты 2-го шага без проверки (т.к. проверка прошла через модель формы выше)
                if($modelOrdersTemp->save(false))
                {
                    // Проверка на авторизацию пользователя
                    if (Yii::app()->user->isGuest)
                    {
                        // Сохраняем данные в сессию для 3-го шага
                        Yii::app()->user->setState('temp_order_id', $modelOrdersTemp->id);
                        Yii::app()->user->setState('temp_order_hash', $modelOrdersTemp->order_hash);

                        // Редирект на 3-й шаг
                        $this->redirect(Yii::app()->createUrl('/order/create/step3'));
                    }
                    else
                    {
                        // Если авторизован, проверяем нужно ли создавать новый профиль для доставки
                        $new_order = null;
                        if ($modelOrdersTemp->profile_id > 0)
                        {
                            // Инициализируем модель профиля по его ID
                            $profile_model = OrdersAddress::model()->findByPk($modelOrdersTemp->profile_id);
                        }
                        else
                        {
                            // Создаем новый профиль доставки
                            $profile_model = $this->createNewAddress($modelOrdersTemp, Yii::app()->user->id);
                        }

                        // Перед созданием заказа, создаем копию неизменяемого пользователем профиля доставки
                        $delivery_model = $this->createNewDelivery($profile_model);

                        // Создаем заказ используя ID созданного неизменяемого профиля доставки
                        $new_order = $this->createNewOrder($modelOrdersTemp, Yii::app()->user->id, $delivery_model->id);

                        // Если заказ успешно создан
                        if ($new_order->id > 0)
                        {
                            // Сохраняем информацию о размещенном заказе
                            Yii::app()->user->setState('created_order_id', $new_order->id);
                            Yii::app()->user->setFlash('successMessage',Yii::t('user', 'Your new order has been added success!'));

                            // Отправляем почтовое уведомление об успешном оформлении заказа
                            $this->newOrderEmailSend($delivery_model, $new_order);

                            // Перекидываем на информационную страницу
                            $this->redirect(Yii::app()->createUrl('/order/create/info/id/'.$new_order->id));
                        }
                        else
                        {
                            Yii::app()->user->setFlash('errorMessage',Yii::t('user', 'Error occurs while order created!'));
                        }

                        // Перекидываем на информационную страницу
                        $this->redirect(Yii::app()->createUrl('/order/create/info'));
                    }
                }
            }
        }

        // Рендер формы
        $this->render('step2',array('model'=>$modelForm));
    }

    /**
     * Экшен страницы 3-го шага оформления заказа
     */
    public function actionStep3()
    {
        // Выкидываем пользователя с 3го шага, если он авторизирован на 2ой шаг
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->createUrl('/order/create/step2'));

        // Если не установлен id заказа, перекидываем на шаг 1
        if (Yii::app()->user->getState('temp_order_id') < 1)
            $this->redirect(Yii::app()->createUrl('/order/create/step1'));

        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Step 3');

        // Подключаем скрипты бутстрапа
        Yii::app()->clientScript->registerPackage('bootstrap');

        // Создаем модель формы Шага 3
        $modelForm = new Step3Form();

        // Ajax проверка на ошибки
        if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
        {
            echo CActiveForm::validate($modelForm);
            Yii::app()->end();
        }

        // Обработка POST запроса (сохранение данных 1-го шага)
        if(isset($_POST['Step3Form']))
        {
            $modelForm->attributes = $_POST['Step3Form'];
            if($modelForm->validate())
            {
                // Проверку не наличие не делаем, так как она прошла выше в валидации
                $modelOrdersTemp = OrdersTemp::model()->findByPk($modelForm->order_id);
                $modelOrdersTemp->step_num = '3';
                $modelOrdersTemp->email = $modelForm->email;
                $modelOrdersTemp->name = $modelForm->name;
                $modelOrdersTemp->phone = $modelForm->phone;
                $modelOrdersTemp->timestamp = new CDbExpression('NOW()');

                // Сохраняем результаты 3-го шага без проверки (т.к. проверка прошла через модель формы выше)
                if($modelOrdersTemp->save(false))
                {
                    // Создаем новый аккаунт пользователя автоматически
                    $new_password = UString::generate_password();
                    $user_id = $this->createNewUser($modelOrdersTemp->email,$new_password);

                    // Создаем новый профиль (адрес) пользователя для отправки посылки
                    if ($user_id > 0)
                    {
                        // Создаем новый профиль доставки
                        $profile_model = $this->createNewAddress($modelOrdersTemp, $user_id);

                        // Перед созданием заказа, создаем копию неизменяемого пользователем профиля доставки
                        $delivery_model = $this->createNewDelivery($profile_model);

                        // Отправляем E-mail о создании нового аккаунта
                        if($delivery_model->id > 0)
                        {
                            // Отправляем почтовое уведомление об успешной регистрации
                            UMail::userSendEmail($user_id,'user_registration',array('email'=>$modelOrdersTemp->email,'newpwd'=>$new_password));
                        }
                    }

                    // Создаем новый заказ на основе данных пользователя из временной таблицы
                    if ($user_id > 0 && $profile_model->id > 0)
                    {
                        $new_order = $this->createNewOrder($modelOrdersTemp, $user_id, $delivery_model->id);

                        // Отправляем пользователю уведомление об оформлении заказа
                        if($new_order->id > 0)
                        {
                            // Сохраняем информацию о размещенном заказе
                            Yii::app()->user->setState('created_order_id', $new_order->id);
                            Yii::app()->user->setFlash('successMessage',Yii::t('user', 'Your new order has been added success!'));

                            // Отправляем почтовое уведомление об успешном оформлении заказа
                            $this->newOrderEmailSend($profile_model, $new_order);

                            // Перекидываем на информационную страницу
                            $userModel = User::model()->findByPk($user_id);
                            $this->redirect(Yii::app()->createUrl('/order/create/info/id/'.$new_order->id.'/h/'.md5($userModel->salt)));
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash('errorMessage',Yii::t('user', 'Error occurs while save user or profile!'));
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('errorMessage',Yii::t('user', 'Error occurs while save temp orders info!'));
                }

                // Перекидываем на информационную страницу
                $this->redirect(Yii::app()->createUrl('/order/create/info'));
            }
        }

        // Рендер формы
        $this->render('step3',array('model'=>$modelForm));
    }

    /**
     * Экшен страницы с информацией о заказе
     */
    public function actionInfo()
    {
        // Устанавливаем Title странице
        $this->pageTitle = Yii::app()->name.' - '.Yii::t('user', 'Order info');

        // Активируем лайаут с одной колонкой
        $this->layout = '//layouts/one_column';

        // Переменная модели
        $modelOrder = null;

        // Получаем ID созданного заказа если он есть
        $order_id = intval(Yii::app()->request->getQuery('id'));

        // Получаем HASH пользователя если он есть (используется для доступа к информации о заказе без авторизации)
        // Хеш - это md5(user->salt)
        $user_hash = Yii::app()->request->getQuery('h');

        // Если ID заказа получен, проверяем что он соответствует пользователю
        if ($order_id > 0)
        {
            // Если гость
            if (Yii::app()->user->isGuest)
            {
                // Если существует переданных хеш в ссылке
                if ($user_hash != '')
                {
                    // Вытаскиваем заказ по его ID
                    $modelOrders_temp = Orders::model()->findByPk($order_id);

                    // Вытаскиваем пользователя, к которому привязан заказ
                    $modelUser = User::model()->findByPk($modelOrders_temp->user_id);

                    // Сравниваем хеши, если совпадают, значит пользователь имеет право на просмотр заказа
                    if(md5($modelUser->salt)==$user_hash)
                    {
                        $modelOrder = $modelOrders_temp;
                    }
                }
            }
            else
            {
                // Инициализируем модель заказов по ID заказа и ID пользователя
                $modelOrder = Orders::model()->find('id=:id AND user_id=:user_id', array(':id'=>$order_id,':user_id'=>Yii::app()->user->id));
            }

            if ($modelOrder===null)
            {
                $error_message = str_replace("{order_id}", $order_id, Yii::t('user', 'The order #{order_id} is not found!'));
                Yii::app()->user->setFlash('errorMessage',$error_message);
            }
        }
        else
        {
            Yii::app()->user->setFlash('errorMessage',Yii::t('user', 'The order is not defined!'));
        }

        // Рендер формы
        $this->render('info',array('model'=>$modelOrder));
    }

    /**
     * Отправка E-mail пользователю при оформлении заказа
     *
     * @param $profile_model
     * @param $new_order
     */
    private function newOrderEmailSend($profile_model, $new_order)
    {
        // Вытаскиваем страну доставки (для отправки данных пользователю)
        $contryModel = Country::model()->findByPk($profile_model->country_id);

        // Формируем полный адрес для доставки
        $full_address = $profile_model->zip_code . ', ' . $contryModel->name_ru . ', ' . $profile_model->city . ', ' . $profile_model->address;

        // Вытаскиваем категорию заказа
        if($new_order->category_id > 0)
        {
            $categoryModel = Categories::model()->findByPk($new_order->category_id);
            $category_name = $categoryModel->name_ru;
        }
        else
        {
            $category_name = Yii::t('user', 'Any category');
        }

        // Формируем параметры заказа
        $gift_params =  $category_name . '; ' . $new_order->getWhomByCode($new_order->whom) . '; ' . Yii::t('user', 'age: ') . $new_order->age . '; ' . Yii::t('user', 'hobbies: ') . $new_order->hobbies . '; ' . Yii::t('user', 'about: ') . $new_order->about . '; ' . Yii::t('user', 'message: ') . $new_order->message . '; ' . Yii::t('user', 'prize from: ') . $new_order->prize_from;

        // Вытаскиваем информацию о пользователе (владельце заказа)
        $userModel = User::model()->findByPk($new_order->user_id);

        // Вызываем функцию отправки сообщения пользователю и передаем параметры
        UMail::userSendEmail(Yii::app()->user->id, 'user_new_order', array(
            'order_id'=>$new_order->id,
            'full_address'=>$full_address,
            'user_comment'=>$profile_model->comments,
            'recipient'=>$profile_model->recipient,
            'gift_params'=>$gift_params,
            'order_price'=>$new_order->price.' '.$new_order->currency,
            'pay_url'=>$this->createAbsoluteUrl('/order/create/info',array('id'=>$new_order->id,'h'=>md5($userModel->salt)))
            )
        );
    }

    /**
     * Создает пользователя и возвращает ID
     * также отправляет E-mail уведомление пользователю
     *
     * @param $email
     *
     * @param $new_password
     * @return int|string
     */
    private function createNewUser($email,$new_password)
    {
        Yii::app()->getModule('user');
        $userModel = new User('createUser');
        $userModel->email = $email;
        $userModel->password = $new_password;
        $userModel->ip = Yii::app()->request->userHostAddress;

        // Создаем пользователя, если пользователь не создается то далее делается rollBack базы
        if ($userModel->validate())
        {
            $userModel->save(false);

            // Создаем профиль пользователя (запись в отедльной таблице)
            $profileModel = new Profile();
            $profileModel->user_id = $userModel->uid;
            $profileModel->save(false);

            // Возвращаем ID пользователя
            return $userModel->uid;
        }
        else
        {
            Yii::app()->user->setFlash('errorMessage',Yii::t('user', 'Error occurs while save user or profile!'));
            //print_r($userModel->getErrors());
        }

        return 0;
    }

    /**
     * Создание нового профиля доставки пользователя
     *
     * @param $modelOrdersTemp - объект временой модели заказов
     * @param $user_id - ID пользователя
     *
     * @return int|object
     */
    private function createNewAddress($modelOrdersTemp, $user_id)
    {
        // Создаем объект модели
        $modelAddress = new OrdersAddress();

        $modelAddress->user_id = $user_id;
        $modelAddress->zip_code = $modelOrdersTemp->zip_code;
        $modelAddress->country_id = $modelOrdersTemp->country_id;
        $modelAddress->city = $modelOrdersTemp->city;
        $modelAddress->address = $modelOrdersTemp->address;
        $modelAddress->recipient = $modelOrdersTemp->recipient;
        $modelAddress->comments = $modelOrdersTemp->comments;
        $modelAddress->timestamp = new CDbExpression('NOW()');

        if($modelAddress->save(false))
        {
            return $modelAddress;
        }

        return 0;
    }

    /**
     * Создание постоянного адреса заказа
     *
     * @param $profile_model - профиль доставки пользователя
     *
     * @return int|object
     */
    private  function createNewDelivery($profile_model)
    {
        // Создаем объект модели
        $modelDelivery = new OrdersDelivery();

        $modelDelivery->user_id = $profile_model->user_id;
        $modelDelivery->zip_code = $profile_model->zip_code;
        $modelDelivery->country_id = $profile_model->country_id;
        $modelDelivery->city = $profile_model->city;
        $modelDelivery->address = $profile_model->address;
        $modelDelivery->recipient = $profile_model->recipient;
        $modelDelivery->comments = $profile_model->comments;
        $modelDelivery->timestamp = new CDbExpression('NOW()');

        if($modelDelivery->save(false))
        {
            return $modelDelivery;
        }

        return 0;
    }

    /**
     * Создание нового заказа на основе OrdersTemp
     *
     * @param $modelOrdersTemp
     * @param $user_id
     * @param $profile_id
     *
     * @return int|object
     */
    private function createNewOrder($modelOrdersTemp, $user_id, $profile_id)
    {
        $modelOrder = new Orders();
        $modelOrder->user_id = $user_id;
        $modelOrder->profile_id = $profile_id;
        $modelOrder->price = $modelOrdersTemp->price;
        $modelOrder->currency = $modelOrdersTemp->currency;
        $modelOrder->category_id = $modelOrdersTemp->category_id;
        $modelOrder->whom = $modelOrdersTemp->whom;
        $modelOrder->age = $modelOrdersTemp->age;
        $modelOrder->hobbies = $modelOrdersTemp->hobbies;
        $modelOrder->about = $modelOrdersTemp->about;
        $modelOrder->message = $modelOrdersTemp->message;
        $modelOrder->prize_from = $modelOrdersTemp->prize_from;
        $modelOrder->status = 'NEW';
        $modelOrder->timestamp = new CDbExpression('NOW()');

        if($modelOrder->save(false))
        {
            return $modelOrder;
        }

        return 0;
    }
}