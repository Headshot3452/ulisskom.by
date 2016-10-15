<?php

/**
 * This is the model class for table "contacts_phone".
 *
 * The followings are the available columns in table 'contacts_phone':
 * @property string $id
 * @property string $language_id
 * @property string $number
 * @property string $operator
 * @property integer $status
 */
class Complaints extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'complaints';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			array('user_id, time, post_id, module_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, user_id, time, post_id, module_id, text', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app','ID'),
			'language_id' => Yii::t('app','Language'),
			'user_id' => Yii::t('app','User'),
			'time' => Yii::t('app','Time'),
			'post_id' => Yii::t('app','Post'),
			'module_id' => Yii::t('app','Module'),
            'text' => Yii::t('app','Text complaint')
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
		$criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('module_id',$this->module_id);
        $criteria->compare('text',$this->text);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactsPhone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
    {
	    return array(
				'LanguageBehavior' => array(
	                'class' => 'application.behaviors.LanguageBehavior',
	            ),
	        );
    }

    public static function getComplaintsForPost($post_id, $module_id, $language_id=1)
    {
    	return self::model()->language($language_id)->findAll('post_id=:post_id AND module_id=:module_id', array('post_id'=>$post_id, ':module_id'=>$module_id));
    }

    public static function removeComplaint($id)
    {
    	self::model()->deleteAllByAttributes(array('id'=>$id));
    }

    public static function checkComplaitForUser($post_id, $module_id)
    {
        return self::model()->find('post_id=:post_id AND module_id=:module_id AND user_id=:user_id',
            array(':post_id'=>$post_id, ':module_id'=>$module_id, ':user_id'=>Yii::app()->user->id));
    }
}
