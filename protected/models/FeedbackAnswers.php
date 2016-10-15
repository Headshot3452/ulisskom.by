<?php

/**
 * This is the model class for table "feedback_answers".
 *
 * The followings are the available columns in table 'feedback_answers':
 * @property string $id
 * @property string $language_id
 * @property string $feedback_id
 * @property string $settings_feedback_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Feedback $feedback
 * @property SettingsFeedback $settingsFeedback
 */
class FeedbackAnswers extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'feedback_answers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value', 'required'),
			array('language_id, feedback_id, settings_feedback_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, feedback_id, settings_feedback_id, value', 'safe', 'on'=>'search'),
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
			'feedback' => array(self::BELONGS_TO, 'Feedback', 'feedback_id'),
			'settingsFeedback' => array(self::BELONGS_TO, 'SettingsFeedback', 'settings_feedback_id'),
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
			'feedback_id' => 'Feedback',
			'settings_feedback_id' => 'Settings Feedback',
			'value' => 'Value',
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
		$criteria->compare('feedback_id',$this->feedback_id,true);
		$criteria->compare('settings_feedback_id',$this->settings_feedback_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FeedbackAnswers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getFeedbackAnswers($tree_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'tree_id=:tree_id';
        $criteria->params = array(':tree_id'=>$tree_id);
        $criteria->order = 'sort ASC';

        return SettingsFeedback::model()->findAll($criteria);
    }

    public static function getAnswersForFeedback($tree_id, $feedback_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'settings_feedback_id=:settings_feedback_id AND feedback_id=:feedback_id';
        $criteria->params = array(':settings_feedback_id'=>$tree_id, ':feedback_id'=>$feedback_id);

        return self::model()->find($criteria);
    }
}
