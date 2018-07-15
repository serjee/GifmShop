<?php

class Step3Form extends CFormModel
{
    /**
     * Выбранная пользователем платежная система
     * @var string
     */
    public $order_id;
    public $order_hash;
    public $email;
    public $name;
    public $phone;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        // Правила формы для первого шага оформления заказа
        return array(
            array('order_id, order_hash, email, name, phone', 'required'),
            array('email, name', 'length', 'max'=>50),
            array('phone', 'length', 'max'=>20),
            array('order_id', 'validateOrder'),
        );
    }

    /**
     * Валидатор для проверки соответствия id и хеша заказа (защита от подмены)
     * @return bool
     */
    public function validateOrder()
    {
        $hash = OrdersTemp::model()->find('id=:id AND order_hash=:order_hash', array(':id'=>$this->order_id,':order_hash'=>$this->order_hash));
        if ($hash === null)
        {
            $this->addError('order_hash', 'Неверный код проверки для данного заказа. Пожалуйста, повторите заказ заново.');
            return false;
        }
    }
}