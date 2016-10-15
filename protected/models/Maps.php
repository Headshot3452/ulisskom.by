<?php

/**
 * This is the model class for table "maps".
 *
 * The followings are the available columns in table 'maps':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $center
 * @property integer $zoom
 * @property string $type
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property MapsPlacemark[] $mapsPlacemarks
 */
class Maps extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'maps';
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
			array('zoom, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('center', 'length', 'max'=>40),
			array('type', 'length', 'max'=>22),
            array('description','safe'),
            array('status', 'default', 'value'=>1),
            array('center', 'default', 'value'=>'55.76, 37.64'),
            array('zoom', 'default', 'value'=>10),
            array('type', 'default', 'value'=>'yandex#map'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, center, zoom, type, status', 'safe', 'on'=>'search'),
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
			'mapsPlacemarks' => array(self::HAS_MANY, 'MapsPlacemark', 'map_id'),
			'mapsGroups' => array(self::HAS_MANY, 'MapsPlacemarkGroup', 'maps_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('app','Title'),
			'description' => Yii::t('app','Description'),
			'center' => Yii::t('app','Center'),
			'zoom' => Yii::t('app','Zoom'),
			'type' => Yii::t('app','Type'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('center',$this->center,true);
		$criteria->compare('zoom',$this->zoom);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Maps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterSave()
    {
        parent::afterSave();

        if (!empty($this->mapsPlacemarks))
        {
            foreach ($this->mapsPlacemarks as $item)
            {
                $item->map_id=$this->id;
                $item->save();
            }
        }
    }

    public function getCenter()
    {
        if ($this->center=='')
        {
            $this->center='55.76, 37.64';
        }
        return $this->center;
    }

    public function getZoom()
    {
        if ($this->zoom=='')
        {
            $this->zoom='10';
        }
        return $this->zoom;
    }

    public function getType()
    {
        if ($this->type=='')
        {
            $this->type='yandex#map';
        }
        return $this->type;
    }

    public static function getAllForMenu()
    {
        return self::model()->findAll(array('condition'=>'status=1 OR status=2'));
    }
}
