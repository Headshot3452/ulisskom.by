<?php

/**
 * This is the model class for table "structure_modules".
 *
 * The followings are the available columns in table 'structure_modules':
 * @property string $id
 * @property string $structure_id
 * @property string $module_id
 * @property integer $tree_id
 *
 * The followings are the available model relations:
 * @property Modules $module
 * @property Structure $structure
 */
class StructureModules extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'structure_modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('structure_id, module_id', 'required'),
			array('structure_id, module_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, structure_id, module_id', 'safe', 'on'=>'search'),
			array('tree_id', 'numerical', 'integerOnly'=>true),
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
			'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
			'structure' => array(self::BELONGS_TO, 'Structure', 'structure_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'structure_id' => Yii::t('app','Structure'),
			'module_id' => Yii::t('app','Module'),
			'tree_id' => Yii::t('app','Tree'),
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
		$criteria->compare('structure_id',$this->structure_id,true);
		$criteria->compare('module_id',$this->module_id,true);
		$criteria->compare('tree_id',$this->tree_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StructureModules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function init()
    {
        parent::init();

        $this->onAddModule = array('CoreEvents','onAddModule');
        $this->onDeleteModule = array('CoreEvents','onDeleteModule');
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->hasEventHandler('onAddModule'))
        {
            $event= new CModelEvent($this);
            $this->onAddModule($event);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->hasEventHandler('onDeleteModule'))
        {
            $event= new CModelEvent($this);
            $this->onDeleteModule($event);
        }
    }

    public function onAddModule($event)
    {
        $this->raiseEvent('onAddModule',$event);
    }

    public function onDeleteModule($event)
    {
        $this->raiseEvent('onDeleteModule',$event);
    }
}
