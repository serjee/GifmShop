<?php

/**
 * Модель контактной формы
 */
class ContactForm extends CFormModel
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Правила валидации
     */
    public function rules()
    {
        $rules = array(
            array('name, email, subject, body', 'required'),
            array('email', 'email'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
        if(extension_loaded('gd') && $this->verifyCode!==false && Yii::app()->user->isGuest){
            $rules[] = array('verifyCode','captcha','allowEmpty'=>false);
        }
        return $rules;
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'verifyCode'=>'Verification Code',
            'name'=>'Ваше имя',
            'email'=>'E-mail',
            'subject'=>'Тема сообщения',
            'body'=>'Сообщение',
        );
    }
}
