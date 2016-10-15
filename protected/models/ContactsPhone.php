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
class ContactsPhone extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contacts_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, operator, status', 'required'),
			array('status', 'numerical', 'integerOnly' => true),
			array('language_id', 'length', 'max' => 11),
			array('number, operator', 'length', 'max' => 255),
			array('id, language_id, number, operator, status, sort', 'safe', 'on' => 'search'),
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
			'language_id' => Yii::t('app','Language'),
			'number' => 'Number',
			'operator' => 'Operator',
			'status' => 'Status',
			'sort' => 'Sort'
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
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('language_id', $this->language_id, true);
		$criteria->compare('number', $this->number, true);
		$criteria->compare('operator', $this->operator, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('sort', $this->sort);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
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
}
