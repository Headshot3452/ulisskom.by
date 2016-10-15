<?php

/**
 * This is the model class for table "maps_placemark_group".
 *
 * The followings are the available columns in table 'maps_placemark_group':
 * @property string $id
 * @property string $language_id
 * @property string $title
 * @property integer $status
 * @property integer $sort
 */
class MapsPlacemarkGroup extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'maps_placemark_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, status, sort', 'required'),
			array('status, sort', 'numerical', 'integerOnly'=>true),
			array('language_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>255),
			array('status', 'default', 'value'=>1),
			array('center', 'default', 'value'=>'55.76, 37.64'),
            array('zoom', 'default', 'value'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, title, status, sort, center, zoom', 'safe', 'on'=>'search'),
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
			'groupPlacemarks' => array(self::HAS_MANY, 'MapsPlacemark', 'group_id'),
			'maps' => array(self::BELONGS_TO, 'Maps', 'maps_id'),
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
			'sort' => Yii::t('app','Sort'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MapsPlacemarkGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	} 

	public static function getGroupPlacemark($maps_id)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('maps_id', $maps_id);
		$criteria->order = 'sort ASC';

		return self::model()->active()->findAll($criteria);
	}
}
