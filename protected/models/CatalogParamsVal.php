<?php

/**
 * This is the model class for table "catalog_params_val".
 *
 * The followings are the available columns in table 'catalog_params_val':
 * @property integer $id
 * @property integer $params_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CatalogParams $params
 * @property CatalogProductsParams[] $catalogProductsParams
 */
class CatalogParamsVal extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_params_val';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('value', 'filter', 'filter'=>'trim'),
			array('params_id, value', 'required'),
			array('params_id', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, params_id, value', 'safe', 'on'=>'search'),
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
			'params' => array(self::BELONGS_TO, 'CatalogParams', 'params_id'),
			'catalogProductsParams' => array(self::HAS_MANY, 'CatalogProductsParams', 'value_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'params_id' => Yii::t('app','Params'),
			'value' => Yii::t('app','Value'),
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
		$criteria->compare('params_id',$this->params_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogParamsVal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
