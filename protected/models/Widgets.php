<?php

/**
 * This is the model class for table "widgets".
 *
 * The followings are the available columns in table 'widgets':
 * @property integer $id
 * @property string $module_id
 * @property string $title
 * @property string $name
 * @property string $settings
 * @property integer $private
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property StructureWidgets[] $structureWidgets
 * @property Modules $module
 */
class Widgets extends Model
{
    const MODULE_PRIVATE=1;
    const MODULE_PUBLIC=0;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'widgets';
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
			array('module_id, title, settings, private, status', 'required'),
			array('private, status', 'numerical', 'integerOnly'=>true),
			array('module_id', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module_id, title, settings, private, status', 'safe', 'on'=>'search'),
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
			'structureWidgets' => array(self::HAS_MANY, 'StructureWidgets', 'widget_id'),
            'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'module_id' => Yii::t('app','Module'),
			'title' => Yii::t('app','Title'),
            'name' => Yii::t('app','Name'),
			'settings' => Yii::t('app','Settings'),
			'private' => Yii::t('app','Private'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('module_id',$this->module_id,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('name',$this->name,true);
		$criteria->compare('settings',$this->settings,true);
		$criteria->compare('private',$this->private);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Widgets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function scopes()
    {
        $array=$this->getCriteriaAlias();
        return array(
            'public'=>array(
                'condition'=>'`'.$array['alias'].'`.`private`='.self::MODULE_PUBLIC
            )
        );
    }

    public static function getPublic($key=null)
    {
        $array=array(self::MODULE_PUBLIC=>Yii::t('app','Public'),
            self::MODULE_PRIVATE=>Yii::t('app','Private')
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }
}
