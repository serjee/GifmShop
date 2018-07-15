<?php

/**
 * This is the model class for table "{{orders_address}}".
 *
 * The followings are the available columns in table '{{orders_address}}':
 * @property string $id
 * @property string $user_id
 * @property string $zip_code
 * @property integer $country_id
 * @property string $city
 * @property string $address
 * @property string $comments
 * @property string $recipient
 * @property string $timestamp
 */
class OrdersAddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdersAddress the static model class
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
		return '{{orders_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, zip_code, country_id, city, address, recipient', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('zip_code', 'length', 'max'=>7),
			array('city', 'length', 'max'=>50),
			array('recipient', 'length', 'max'=>100),
            array('comments', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, zip_code, country_id, city, address, comments, recipient, timestamp', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('user', 'ID Address'),
			'user_id' => Yii::t('user', 'User Address'),
			'zip_code' => Yii::t('user', 'Zip Code'),
			'country_id' => Yii::t('user', 'Country'),
			'city' => Yii::t('user', 'City'),
			'address' => Yii::t('user', 'Address'),
			'comments' => Yii::t('user', 'Comments'),
			'recipient' => Yii::t('user', 'Recipient'),
			'timestamp' => Yii::t('user', 'Timestamp'),
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
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('recipient',$this->recipient,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}