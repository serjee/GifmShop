<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $uid
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $role
 * @property string $time_create
 * @property string $time_update
 * @property integer $enabled
 * @property string $ip
 */
class AdminUser extends User
{  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('email', 'required'),
            array('password', 'required', 'on'=>'createUser'),			
			array('enabled', 'numerical', 'integerOnly'=>true),
            array('email', 'email', 'message'=>Yii::t('admin', 'Invalid email')),
            array('email', 'unique', 'message'=>Yii::t('admin', 'E-mail is busy')),
            array('email', 'length', 'max'=>50),
            array('password, salt', 'length', 'max'=>32),
            array('role', 'length', 'min'=>4, 'max'=>10),
			// The following rule is used by search()
			array('uid, email, role, enabled, ip', 'safe', 'on'=>'search'),
		);
        return $rules;
	}
    
    /**
     * Get string information about role
     */
    public function getRoleStringById($roleId)
    {
        switch($roleId)
        {
            case User::ROLE_ADMIN:
                return Yii::t('admin', 'Admin');
            case User::ROLE_MODERATOR:
                return Yii::t('admin', 'Moderator');
            case User::ROLE_USER:
                return Yii::t('admin', 'User');
        }
    }
    
    /**
     * Get string information about status
     */
    public function getStatusStringById($statusId)
    {
        if ($statusId == 0)
        {
            return Yii::t('admin', 'No');
        }
        else
        {
            return Yii::t('admin', 'Yes');            
        }
    }

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'UID',
            'email' => Yii::t('admin', 'E-mail'),
			'password' => Yii::t('admin', 'Password'),
			'salt' => Yii::t('admin', 'Code word'),			
			'role' => Yii::t('admin', 'Role'),
            'time_create' => Yii::t('admin', 'Time Create'),
			'time_update' => Yii::t('admin', 'Time Update'),            
			'enabled' => Yii::t('admin', 'Is active'),
            'ip' => Yii::t('admin', 'IP address'),
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

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('enabled',$this->enabled,true);
        $criteria->compare('ip',$this->ip);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}