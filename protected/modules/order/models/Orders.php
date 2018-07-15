<?php

/**
 * This is the model class for table "{{orders}}".
 *
 * The followings are the available columns in table '{{orders}}':
 * @property string $id
 * @property string $user_id
 * @property string $profile_id
 * @property string $price
 * @property string $currency
 * @property integer $category_id
 * @property string $whom
 * @property integer $age
 * @property string $hobbies
 * @property string $about
 * @property string $message
 * @property string $prize_from
 * @property string $status
 * @property string $timestamp
 */
class Orders extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, profile_id, category_id, status', 'required'),
			array('category_id, age', 'numerical', 'integerOnly'=>true),
			array('user_id, profile_id', 'length', 'max'=>10),
			array('price', 'length', 'max'=>12),
			array('currency', 'length', 'max'=>3),
			array('whom', 'length', 'max'=>9),
			array('prize_from, mail_id', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
            array('hobbies, about, message, msg_to_user','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, profile_id, price, currency, category_id, whom, age, hobbies, about, message, prize_from, status, timestamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('user', 'Order ID'),
			'user_id' => Yii::t('user', 'User Order'),
			'profile_id' => Yii::t('user', 'Profile Order'),
			'price' => Yii::t('user', 'Price Order'),
			'currency' => Yii::t('user', 'Currency Order'),
			'category_id' => Yii::t('user', 'Category Order'),
			'whom' => Yii::t('user', 'Whom Order'),
			'age' => Yii::t('user', 'Age Order'),
			'hobbies' => Yii::t('user', 'Hobbies Order'),
			'about' => Yii::t('user', 'About Order'),
			'message' => Yii::t('user', 'Message Order'),
			'prize_from' => Yii::t('user', 'Prize From Order'),
			'status' => Yii::t('user', 'Status Order'),
			'timestamp' => Yii::t('user', 'Timestamp Order'),
            'mail_id' => Yii::t('user', 'Mail Id'),
            'msg_to_user' => Yii::t('user', 'Message to user'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('profile_id',$this->profile_id,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('whom',$this->whom,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('hobbies',$this->hobbies,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('prize_from',$this->prize_from,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
		));
	}

    /**
     * Информация о статусе в человекопонятном виде
     */
    public function getWordStatusById($statusId)
    {
        switch($statusId)
        {
            case 'NEW':
                return Yii::t('user', 'New order');
            case 'PAYED':
                return Yii::t('user', 'Payed order');
            case 'PROCESS':
                return Yii::t('user', 'Process order');
            case 'SHIPPING':
                return Yii::t('user', 'Shipping order');
            case 'SENT':
                return Yii::t('user', 'Sent order');
            case 'DONE':
                return Yii::t('user', 'Done order');
            case 'CANCELED':
                return Yii::t('user', 'Canceled order');
            case 'DELETED':
                return Yii::t('user', 'Deleted order');
        }
    }

    /**
     * Информация о валюте в человекопонятном виде
     */
    public function getCurrencyByCode($curCode)
    {
        switch($curCode)
        {
            case 'RUB':
                return Yii::t('user', 'rubles');
            case 'USD':
                return Yii::t('user', 'dollars');
            case 'EUR':
                return Yii::t('user', 'euro');
        }
    }

    /**
     * Информация о валюте в человекопонятном виде
     */
    public function getWhomByCode($whomCode)
    {
        switch($whomCode)
        {
            case 'ALL':
                return Yii::t('user', 'All whom');
            case 'MAN':
                return Yii::t('user', 'Man whom');
            case 'WOMAN':
                return Yii::t('user', 'Woman whom');
            case 'CHILDBOY':
                return Yii::t('user', 'Childboy whom');
            case 'CHILDGIRL':
                return Yii::t('user', 'Childgirl whom');
        }
    }

    /**
     * Получаем получателя профиля по ID
     *
     * @param $profile_id
     * @internal param $order_id
     * @return string
     */
    public function getProfileById($profile_id)
    {
        $ordersaddress_model = OrdersAddress::model()->findByPk($profile_id);
        if ($ordersaddress_model!==null)
        {
            return $ordersaddress_model->recipient;
        }

        return 'N/A';
    }

    /**
     * Получаем получателя профиля по ID
     *
     * @param $order_id
     * @return string
     */
    public function getDeliveryByOrderId($order_id)
    {
        $orders_model = Orders::model()->find('id=:id AND user_id=:user_id', array(':id'=>$order_id,':user_id'=>Yii::app()->user->id));

        if ($orders_model!==null)
        {
            $ordersaddress_model = OrdersAddress::model()->findByPk($orders_model->profile_id);
            if ($ordersaddress_model!==null)
            {
                $country_model = Country::model()->findByPk($ordersaddress_model->country_id);

                return $ordersaddress_model->zip_code.', '.$country_model->name_ru.', '.$ordersaddress_model->city.', '.$ordersaddress_model->address.', '.$ordersaddress_model->recipient;
            }
        }
        return 'N/A';
    }

}