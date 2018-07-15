<?php

/**
 * This is the model class for table "{{prices}}".
 *
 * The followings are the available columns in table '{{prices}}':
 * @property string $id
 * @property string $price_ru
 * @property string $price_us
 * @property string $price_eu
 * @property string $sort_id
 * @property string $timestamp
 */
class Prices extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Prices the static model class
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
		return '{{prices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('timestamp', 'required'),
			array('price_ru, price_us, price_eu', 'length', 'max'=>12),
			array('sort_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, price_ru, price_us, price_eu, sort_id, timestamp', 'safe', 'on'=>'search'),
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
			'price_ru' => 'Price Ru',
			'price_us' => 'Price Us',
			'price_eu' => 'Price Eu',
			'sort_id' => 'Sort',
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
		$criteria->compare('price_ru',$this->price_ru,true);
		$criteria->compare('price_us',$this->price_us,true);
		$criteria->compare('price_eu',$this->price_eu,true);
		$criteria->compare('sort_id',$this->sort_id,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}