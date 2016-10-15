<?php

/**
 * This is the model class for table "user_info".
 *
 * The followings are the available columns in table 'user_info':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $patronymic
 * @property string $last_name
 * @property string $birth
 * @property string $phone
 * @property integer $sum
 * @property integer $sex
 * @property integer $discount
 * @property string $orders_count
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserInfo extends Model
{
    public $birth_day = 0;
    public $birth_month = 0;
    public $birth_year = 0;

    const SEX_FEMALE =1;
    const SEX_MALE =2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, last_name, phone', 'required','on'=>'insert, update, settings_user'),
            array('name, last_name, phone', 'safe','on'=>'user_create'),
            array('sum, discount, orders_count, status', 'numerical', 'integerOnly'=>true),
			array('user_id, birth', 'length', 'max'=>10),
			array('name, patronymic, last_name', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>64),
            array('birth_day, birth_month, birth_year, comment, sex','safe'),
            array('birth','datevalidate','on'=>'insert,update'),
            array('birth', 'unsafe', 'on'=>'settings_user'),
            array('nickname', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, name, patronymic, last_name, birth, phone, sum, discount, orders_count, status, sex, nickname', 'safe', 'on'=>'search'),
		);
	}

    public function datevalidate($attribute,$params)
    {
        $this->birth=CDateTimeParser::parse($this->birth_day.'.'.$this->birth_month.'.'.$this->birth_year,'d.M.yyyy');

        if(!$this->birth)
        {
            $this->addError($attribute, Yii::t('app','Date incorrect'));
        }
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'name' =>  Yii::t('app','Name'),
			'patronymic' =>  Yii::t('app','Patronymic'),
			'last_name' => Yii::t('app','Last name'),
			'birth' => Yii::t('app','Birth'),
            'sex' => Yii::t('app', 'Sex'),
			'phone' => Yii::t('app','Phone'),
            'sum' => Yii::t('app','Sum'),
            'discount' => Yii::t('app','Discount'),
            'orders_count' =>  Yii::t('app','Orders Count'),
            'status' =>  Yii::t('app','Status'),
            'nickname' =>  Yii::t('app','Nickname'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('patronymic',$this->patronymic,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('birth',$this->birth,true);
		$criteria->compare('phone',$this->phone,true);
        $criteria->compare('sum',$this->sum);
        $criteria->compare('sex',$this->sex);
        $criteria->compare('discount',$this->discount);
        $criteria->compare('orders_count',$this->orders_count,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('nickname',$this->nickname);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterFind()
    {
        $this->birth_day=Yii::app()->dateFormatter->format('d',$this->birth);
        $this->birth_month=Yii::app()->dateFormatter->format('M',$this->birth);
        $this->birth_year=Yii::app()->dateFormatter->format('yyyy',$this->birth);
    }


    public static function getForUser($user_id)
    {
        return self::model()->findByAttributes(array('user_id'=>$user_id));
    }

    public static function getStatus($key=null)
    {
        $array=array(self::STATUS_OK=>'Хороший клиент',
                     self::STATUS_NOT_ACTIVE=>'Плохой клиент',
                     self::STATUS_DELETED=>'Злой клиент'
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public static function getSex($key=null)
    {
        $array=array(self::SEX_FEMALE=>'Женский',
            self::SEX_MALE=>'Мужской',
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public function getFullName()
    {
        if(isset($this->last_name) && isset($this->name))
        {
            return $this->last_name.' '.$this->name.' '.$this->patronymic;
        }
        return false;
    }

    public function getNameUser()
    {
        if(isset($this->last_name) && isset($this->name))
        {
            return $this->last_name.' '.$this->name;
        }
        return false;
    }

    public function getBirthDay()
    {
        return Yii::app()->dateFormatter->format('d MMMM yyyy', $this->birth);
    }
}
