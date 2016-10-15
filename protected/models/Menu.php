<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property string $id
 * @property integer $language_id
 * @property string $title
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property MenuItem[] $menuItems
 */
class Menu extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu';
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
			array('title', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, title, status', 'safe', 'on'=>'search'),
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
            'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
			'menuItems' => array(self::HAS_MANY, 'MenuItem', 'menu_id',
                                'order'=>'menuItems.sort ASC',
                        ),
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
			'title' => Yii::t('app','Title'),
			'status' => Yii::t('app','Status'),
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
        $criteria->compare('language_id',$this->language_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function geAllForMenu($language_id)
    {
        return self::model()->language($language_id)->notDeleted()->findAll(array('select'=>'t.`id`,t.`title`'));
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
