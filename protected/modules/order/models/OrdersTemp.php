<?php

/**
 * This is the model class for table "{{orders_temp}}".
 *
 * The followings are the available columns in table '{{orders_temp}}':
 * @property string $id
 * @property string $order_hash
 * @property integer $step_num
 * @property string $price
 * @property string $currency
 * @property integer $category_id
 * @property string $whom
 * @property integer $age
 * @property string $hobbies
 * @property string $about
 * @property string $message
 * @property string $prize_from
 * @property string $profile_id
 * @property string $zip_code
 * @property integer $country_id
 * @property string $city
 * @property string $address
 * @property string $comments
 * @property string $recipient
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property string $timestamp
 */
class OrdersTemp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdersTemp the static model class
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
		return '{{orders_temp}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive order inputs.
		return array(
			array('order_hash, hobbies, about, message, address, comments, timestamp', 'required'),
			array('step_num, category_id, age, country_id', 'numerical', 'integerOnly'=>true),
			array('order_hash', 'length', 'max'=>32),
			array('price', 'length', 'max'=>12),
			array('currency', 'length', 'max'=>3),
			array('whom', 'length', 'max'=>5),
			array('prize_from, recipient', 'length', 'max'=>100),
			array('profile_id', 'length', 'max'=>10),
			array('zip_code', 'length', 'max'=>7),
			array('city, email, name', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_hash, step_num, price, currency, category_id, whom, age, hobbies, about, message, prize_from, profile_id, zip_code, country_id, city, address, comments, recipient, email, name, phone, timestamp', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'order_hash' => 'Order Hash',
			'step_num' => 'Step Num',
			'price' => 'Price',
			'currency' => 'Currency',
			'category_id' => 'Category',
			'whom' => 'Whom',
			'age' => 'Age',
			'hobbies' => 'Hobbies',
			'about' => 'About',
			'message' => 'Message',
			'prize_from' => 'Prize From',
			'profile_id' => 'Profile',
			'zip_code' => 'Zip Code',
			'country_id' => 'Country',
			'city' => 'City',
			'address' => 'Address',
			'comments' => 'Comments',
			'recipient' => 'Recipient',
			'email' => 'Email',
			'name' => 'Name',
			'phone' => 'Phone',
			'timestamp' => 'Timestamp',
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
		$criteria->compare('order_hash',$this->order_hash,true);
		$criteria->compare('step_num',$this->step_num);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('whom',$this->whom,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('hobbies',$this->hobbies,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('prize_from',$this->prize_from,true);
		$criteria->compare('profile_id',$this->profile_id,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('recipient',$this->recipient,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}