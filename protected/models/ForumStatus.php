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
class ForumStatus extends Model
{
    const ONE_MOUNT = 1;
    const THREE_MOUNT = 2;
    const SIX_MOUNT = 3;
    const NINE_MOUNT = 4;
    const ONE_YEAR = 5;
    const TWO_YEAR = 6;
    const THREE_YEAR = 7;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'forum_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, period', 'required'),
			array('language_id', 'length', 'max'=>11),
			array('text', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, text, period', 'safe', 'on'=>'search'),
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
			'text' => Yii::t('app','Text'),
			'period' => Yii::t('app','Period'),
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('period',$this->period,true);

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

    public function getIdStatusForumForUser($id)
    {
        $user = Users::model()->findByPk($id);
        $period = date_diff(new DateTime(), new DateTime(date('Y-m-d', $user->create_time)))->days;

        $period = floor($period/30);

        if($period<3)
            return 1;
        if($period>=3 && $period<6)
            return 2;
        if($period>=6 && $period<9)
            return 3;
        if($period>=9 && $period<12)
            return 4;
        if($period>=12 && $period<24)
            return 5;
        if($period>=24 && $period<36)
            return 6;
        if($period>=36)
            return 7;
    }

    public static function getStatusForum($id)
    {
        $period = self::getIdStatusForumForUser($id);

        $model = self::model()->find('period=:period', array(':period'=>$period));

        if($model)
        {
            return $model->text;
        }
        else
        {
            return '';
        }
    }

    public static function getPeriod($id)
    {
        switch($id)
        {
            case 1: return '1 мес.';break;
            case 2: return '3 мес.';break;
            case 3: return '6 мес.';break;
            case 4: return '9 мес.';break;
            case 5: return '1 год';break;
            case 6: return '2 года';break;
            case 7: return '3 года';break;
        }
    }
}
