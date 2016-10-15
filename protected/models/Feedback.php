<?php

/**
 * This is the model class for table "feedback".
 *
 * The followings are the available columns in table 'feedback':
 * @property string $id
 * @property string $language_id
 * @property integer $sort
 * @property integer $time
 * @property integer $tree_id
 * @property string $primech
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property FeedbackAnswers[] $feedbackAnswers
 */
class Feedback extends Model
{
	const STATUS_NEW = 1;
	const STATUS_MODERETION = 5;
	const STATUS_ANSWER = 2;
	const STATUS_ARCHIVE = 3;
	const STATUS_DELETED = 4;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort, time, parent_id, status', 'required'),
			array('sort, time, parent_id, status', 'numerical', 'integerOnly'=>true),
			array('language_id', 'length', 'max'=>11),
			array('primech, ask', 'length', 'max'=>255),
			array('primech, ask', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, sort, time, parent_id, primech, files, status, ask', 'safe', 'on'=>'search'),
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
			'tree' => array(self::BELONGS_TO, 'FeedbackTree', 'parent_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
			'feedbackAnswers' => array(self::HAS_MANY, 'FeedbackAnswers', 'feedback_id'),
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
			'time' => 'Time',
			'parent_id' => 'Tree',
			'primech' => Yii::t('app', 'primech'),
			'status' => 'Status',
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
		$criteria->compare('time',$this->time);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('primech',$this->primech,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getFeedbackProvider($pagesize = 15, $date_from = '', $date_to = '', $status = 1, $sort = 't.sort',$order = 'ASC', $parent_id='')
	{

		$criteria = new CDbCriteria();

		$criteria->with = array('tree', 'feedbackAnswers', 'feedbackAnswers.settingsFeedback' => array('order'=>'settingsFeedback.id ASC'));

		if($status)
		{
			$criteria->addCondition('t.status=:status');
			$params= array(':status'=>$status);
		}

		if($date_from)
		{
			$criteria->addCondition('t.time>:date_from');
			$params[':date_from']=$date_from;
		}

		if($date_to)
		{
			$criteria->addCondition('t.time<:date_to');
			$params[':date_to']=$date_to;
		}

		if($status!=self::STATUS_ARCHIVE)
		{
			$criteria->addCondition('t.status!=3');
		}
		else
		{
			$criteria->addCondition('t.status=3');
		}

		if($parent_id)
		{
			$criteria->addCondition('t.parent_id=:parent_id');
			$params[':parent_id']=$parent_id;
		}

		if(isset($params))
		{
			$criteria->params=$params;
		}

		$criteria->order = $sort.' '.$order;
		return new CActiveDataProvider(new self, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pagesize
			)
		));

	}

	public static function getStatus($id)
	{
		switch ($id)
		{
			case self::STATUS_NEW: return 'Новый';
				break;
			case self::STATUS_MODERETION: return 'В обработке';
				break;
			case self::STATUS_ANSWER: return 'Ответили';
				break;
			case self::STATUS_ARCHIVE: return 'В архив';
				break;
			case self::STATUS_DELETED: return 'Удалить';
				break;
			default : return false;
		}
	}

	public static function getColorStatus($status)
	{
		switch ($status)
		{
			case self::STATUS_NEW: return 'blue';
				break;
			case self::STATUS_MODERETION: return '#fb6b00';
				break;
			case self::STATUS_ANSWER: return 'green';
				break;
			case self::STATUS_ARCHIVE: return 'gray';
				break;
			case self::STATUS_DELETED: return 'red';
				break;
			default : return false;
		}
	}
}
