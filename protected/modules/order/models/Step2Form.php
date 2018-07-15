<?php

class Step2Form extends CFormModel
{
    /**
     * Выбранная пользователем платежная система
     * @var string
     */
    public $id;
    public $order_id;
    public $order_hash;
    public $zip_code;
    public $country_id;
    public $city;
    public $address;
    public $comments;
    public $recipient;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        // Правила формы для первого шага оформления заказа
        return array(
            array('order_id, order_hash, zip_code, country_id, city, address, recipient', 'required'),
            array('id, country_id', 'numerical', 'integerOnly'=>true),
            array('id', 'length', 'max'=>10),
            array('recipient', 'length', 'max'=>100),
            array('zip_code', 'length', 'max'=>6),
            array('city', 'length', 'max'=>50),
            array('order_id', 'validateOrder'),
            array('id', 'validateProfile'),
            array('comments', 'safe'),
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
            $this->addError('order_id', 'Неверный код проверки для данного заказа. Пожалуйста, повторите заказ заново.');
            return false;
        }

        return true;
    }

    /**
     * Валидатор для проверки соответствия profile_id к текущему пользователю
     * @return bool
     */
    public function validateProfile()
    {
        if ($this->id > 0)
        {
            $address = OrdersAddress::model()->find('id=:id AND user_id=:user_id', array(':id'=>$this->id,':user_id'=>Yii::app()->user->id));
            if ($address === null)
            {
                $this->addError('id', 'Неверный код проверки для данного заказа. Пожалуйста, повторите заказ заново.');
                return false;
            }
        }

        return true;
    }
}