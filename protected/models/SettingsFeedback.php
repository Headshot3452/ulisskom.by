<?php

/**
 * This is the model class for table "settings_feedback".
 *
 * The followings are the available columns in table 'settings_feedback':
 * @property string $id
 * @property string $language_id
 * @property integer $sort
 * @property string $name
 * @property string $type
 * @property integer $status
 * @property integer $system
 *
 * The followings are the available model relations:
 * @property FeedbackAnswers[] $feedbackAnswers
 */
class SettingsFeedback extends Model
{
	const TYPE_INT=1;
	const TYPE_TEXT=2;
	const TYPE_DATE=3;
	const TYPE_FILE=4;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings_feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort, name, type, status, system, tree_id', 'required'),
			array('sort, status, system', 'numerical', 'integerOnly'=>true),
			array('language_id', 'length', 'max'=>11),
			array('name, type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, sort, name, tree_id, type, status, system', 'safe', 'on'=>'search'),
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
			'feedbackAnswers' => array(self::HAS_MANY, 'FeedbackAnswers', 'settings_feedback_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'language_id' => 'Language',
			'sort' => 'Sort',
			'name' => Yii::t('app', 'Feedback param name'),
			'type' => Yii::t('app', 'Feedback param type'),
			'status' => 'Status',
			'system' => 'System',
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
		$criteria->compare('sort',$this->sort);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('system',$this->system);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SettingsFeedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function bySort()
	{
			$array=$this->getCriteriaAlias();
			$array['criteria']->mergeWith(array(
					'order'=>'`sort`'
				)
			);
		return $this;
	}

	public static function getAllType()
	{
		return array(self::TYPE_INT => 'Числовой' ,self::TYPE_TEXT => 'Текстовый' , self::TYPE_DATE => 'Дата');
	}

	protected function beforeDelete()
	{
		/*Сделано для реального удаления параметров, а не смены статусов*/
		return true;
	}
}
