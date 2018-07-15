<?php

class QiwiForm extends CFormModel
{
    /**
     * Телефон для Qiwi
     * @var string
     */
    public $phone;
    /**
     * Сумма платежа
     * @var int
     */
    public $order_id;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('phone', 'required', 'message'=>'Введите пожалуйста номер телефона вашего кошелька в QiwiWallet!'),
            array('order_id', 'required', 'message'=>'Номер заказа передан неверно!'),
            array('phone','match','pattern'=>'/\+{1}\d{1,15}/i','message'=>'Телефон заполнен неверно, он должен иметь формат +71234567890'),
            array('order_id', 'numerical', 'integerOnly'=>true),
        );
    }
}