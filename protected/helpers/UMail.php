<?php
/**
 * Класс для отправки писем на основе почтовых шаблонов в базе данных
 *
 * @author     Sergey Bashkov
 * @copyright  (c) 2013 Gifm.ru
 */
class UMail
{
    /**
     * Отправка писем пользователю
     *
     * @param $user_id - ID пользователя
     * @param $template_name - Название шаблона в базе данных
     * @param array $params - Параметры сообщения
     * @return bool - Возвращает TRUE в случае успешной отправки
     */
    public static function userSendEmail($user_id, $template_name, $params=array())
    {
        // Получаем шаблон из базы и вставляем данные для отправки
        $mailtemplates = Mailtemplates::model()->find(array(
            'select'=>'subject, data',
            'condition'=>'name=:name',
            'params'=>array(':name'=>$template_name),
        ));
        $message = CHtml::decode($mailtemplates->data);

        // Вставляем переменные в зависимости от шаблона и переданных параметров
        switch($template_name)
        {
            // Регистрация пользователя
            case 'user_registration':
                $message = str_replace("#SITE_NAME#", Yii::t('user', 'siteurl'), $message);
                $message = str_replace("#E-MAIL#", $params["email"], $message);
                $message = str_replace("#PASSWORD#", $params["newpwd"], $message);
                break;
            // Оформлен новый заказ
            case 'user_new_order':
                $message = str_replace("#SITE_NAME#", Yii::t('user', 'siteurl'), $message);
                $message = str_replace("#ORDER_ID#", $params["order_id"], $message);
                $message = str_replace("#FULL_ADDRESS#", $params["full_address"], $message);
                $message = str_replace("#USER_COMMENT#", $params["user_comment"], $message);
                $message = str_replace("#RECIPIENT#", $params["recipient"], $message);
                $message = str_replace("#GIFT_PARAMS#", $params["gift_params"], $message);
                $message = str_replace("#ORDER_PRICE#", $params["order_price"], $message);
                $message = str_replace("#PAY_URL#", $params["pay_url"], $message);
                break;
        }

        // Вызываем функцию отправки письма пользователю и получаем статус отправки
        return self::user_send_email($user_id, $mailtemplates->subject, $message);
    }

    /**
     * Отправка письма менеджеру магазина
     *
     * @param $template_name - Название шаблона в базе данных
     * @param array $params - Параметры сообщения
     * @return bool - Возвращает TRUE в случае успешной отправки
     */
    public static function salesSendEmail($template_name, $params=array())
    {
        // Получаем шаблон из базы и вставляем данные для отправки
        $mailtemplates = Mailtemplates::model()->find(array(
            'select'=>'subject, data',
            'condition'=>'name=:name',
            'params'=>array(':name'=>$template_name),
        ));
        $message = CHtml::decode($mailtemplates->data);

        // Вставляем переменные в зависимости от шаблона и переданных параметров
        switch($template_name)
        {
            // Оформлен и оплачен новый заказ
            case 'sales_new_order':
                $message = str_replace("#SITE_NAME#", Yii::t('user', 'siteurl'), $message);
                $message = str_replace("#ORDER_ID#", $params["order_id"], $message);
                break;
        }

        // Вызываем функцию отправки письма пользователю и получаем статус отправки
        return self::base_send_email(Yii::app()->params['salesEmail'], $mailtemplates->subject, $message);
    }

    /**
     * Отправка письма администратору магазина
     *
     * @param $subject - Заголовок сообщения
     * @param $message - Текст сообщения
     * @return bool - Возвращает TRUE в случае успешной отправки
     */
    private static function admin_send_email($subject, $message)
    {
        // Вызываем базовую функцию отправки сообщения и получаем статус отправки
        return self::base_send_email(Yii::app()->params['adminEmail'], $subject, $message);
    }

    /**
     * Отправка писем пользователям по их ID
     *
     * @param $user_id - ID пользователя
     * @param $subject - Заголовок сообщения
     * @param $message - Текст сообщения
     * @return bool - Возвращает TRUE в случае успешной отправки
     */
    private static function user_send_email($user_id, $subject, $message)
    {
        // Вызываем принудительно модуль для работы с пользователем
        Yii::app()->getModule('user');

        // Инициализируем модель по ID пользователя
        $user_model = User::model()->findByPk($user_id);

        // Вызываем базовую функцию отправки сообщения и получаем статус отправки
        return self::base_send_email($user_model->email, $subject, $message);
    }

    /**
     * Базовая функция отправки писем через модуль YiiMailer
     *
     * @param $email
     * @param $subject
     * @param $message
     * @return bool
     */
    private static function base_send_email($email, $subject, $message)
    {
        // Используем шаблон 'simple' из /themes/default/views/mail
        $mail = new YiiMailer('simple', array('message'=>$message, 'description'=>Yii::t('user', 'Info message')));

        // генерируем HTML письмо, layout берем из конфига или при помощи $mail->setLayout('layoutName')
        $mail->render();

        // Устанавливаем остальные свойства характерные для PHPMailer
        $mail->From = Yii::app()->params['noreplyEmail'];
        $mail->FromName = Yii::app()->params['fromNameEmail'];
        $mail->Subject = $subject;
        $mail->AddAddress($email);

        // Отправляем письмо
        if ($mail->Send())
        {
            $mail->ClearAddresses();
            return true;
        }
        else
        {
            //Yii::app()->user->setFlash('recoveryMessage',Yii::t('user', 'Error while sending email: {error}', array('{error}' => $mail->ErrorInfo)));
        }

        return false;
    }
}