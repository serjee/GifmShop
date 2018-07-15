<?php

class Step1Form extends CFormModel
{
    /**
     * Выбранная пользователем платежная система
     * @var string
     */
    public $price;
    public $category_id;
    public $whom;
    public $age;
    public $hobbies;
    public $about;
    public $message;
    public $prize_from;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        // Правила формы для первого шага оформления заказа
        return array(
            array('price', 'required'),
            array('category_id, age', 'numerical', 'integerOnly'=>true),
            array('whom','in','range'=>array('ALL','MAN','WOMAN','CHILDBOY','CHILDGIRL'),'allowEmpty'=>false),
            array('price', 'length', 'max'=>12),
            array('prize_from', 'length', 'max'=>100),
            array('hobbies, about, message', 'safe'),
        );
    }
}