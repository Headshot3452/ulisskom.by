<?php

/**
 * This is the model class for table "ask_answer".
 *
 * The followings are the available columns in table 'ask_answer':
 * @property string $id
 * @property string $language_id
 * @property string $group_id
 * @property string $title
 * @property string $text
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property AskAnswerGroups $group
 * @property Language $language
 */
class AskAnswer extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ask_answer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title', 'filter', 'filter'=>'trim'),
			array('group_id, title, text', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('language_id, group_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, group_id, title, text, status', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'AskAnswerGroups', 'group_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
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
			'group_id' => 'Group',
			'title' => 'Title',
			'text' => 'Text',
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
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AskAnswer the static model class
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
}
