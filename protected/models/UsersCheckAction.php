<?php

/**
 * This is the model class for table "users_check_action".
 *
 * The followings are the available columns in table 'users_check_action':
 * @property string $id
 * @property string $user_id
 * @property integer $type_action
 * @property string $hash
 * @property integer $time
 */
class UsersCheckAction extends Model
{
	const TYPE_REGISTRATION = 1;
	const TYPE_RECOVER_PASSWORD = 2;
    const TYPE_CLIENT_RECOVER_PASSWORD = 3;
    
    public $time_active=86400; //3600*24
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersCheckAction the static model class
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
		return 'users_check_action';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type_action, hash, time', 'required'),
			array('type_action, time', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('hash', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, type_action, hash, time', 'safe', 'on'=>'search'),
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
			'user_id' => Yii::t('app','User'),
			'type_action' => Yii::t('app','Type Action'),
			'hash' => Yii::t('app','Hash'),
			'time' => Yii::t('app','Time'),
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
		$criteria->compare('type_action',$this->type_action);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('time',$this->time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function init()
    {
        parent::init();
        
        $this->onUserCheckAction = array('CoreEvents','onUserCheckAction');
    }
    
    public function onUserCheckAction($event)
    {
        $this->raiseEvent('onUserCheckAction',$event);
    }
    
    public function afterSave()
    {
        parent::afterSave();
        if ($this->isNewRecord)
        {
            if ($this->hasEventHandler('onUserCheckAction'))
            {
                $event= new CModelEvent($this);
                $this->onUserCheckAction($event);
            }
        }
    }
    
    public function active()
    {
        $array=$this->getCriteriaAlias();
        $array['criteria']->mergeWith(array(
                'condition'=>'`time` < NOW()'
                )
        );
        return $this;
    }
    
    public function not_active()
    {
        $array=$this->getCriteriaAlias();
        $array['criteria']->mergeWith(array(
                'condition'=>'`time` >= NOW()'
                )
        );
        return $this;
    }

    public static function getItem($type,$hash)
    {
        return self::model()->active()->findByAttributes(array('type_action'=>$type,'hash'=>$hash));
    }
    
    public static function insertAction($user_id,$type_action)
    {
        self::model()->deleteAllByAttributes(array('user_id'=>$user_id));
        $model=new self;
        $model->user_id=$user_id;
        $model->type_action=$type_action;
        $model->time=time()+$model->time_active;
        $model->hash=md5($user_id.$model->time.rand());
        if ($model->save())
        {
            return $model;
        }
    }

    public static function getTypeAction($key=null)
    {
        $array=array(
                    self::TYPE_RECOVER_PASSWORD => array(
                                                  'subject'=>Yii::t('app','Recover password'),
                                                  'action'=>'user/PasswordResetCheck',
                                                  'view_email'=>'user_recover_password',
                                                ),
                    self::TYPE_REGISTRATION => array(
                                                'subject'=>Yii::t('app','Registration'),
                                                'action'=>'user/UserCheck',
                                                'view_email'=>'user_check_email',
                                             ),
                    self::TYPE_CLIENT_RECOVER_PASSWORD => array(
                                                        'subject'=>Yii::t('app','Recover password'),
                                                        'action'=>'client/PasswordResetCheck',
                                                        'view_email'=>'user_recover_password',
                                                    )
                  );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }
}