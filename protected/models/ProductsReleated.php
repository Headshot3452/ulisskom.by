<?php

/**
 * This is the model class for table "products_releated".
 *
 * The followings are the available columns in table 'products_releated':
 * @property string $id
 * @property string $product_id
 * @property string $releated_id
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property CatalogProducts $product
 */
class ProductsReleated extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products_releated';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, releated_id', 'required'),
			array('product_id, releated_id', 'length', 'max'=>11),
			array('sort', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, releated_id, sort', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'CatalogProducts', 'product_id'),
            'releated' => array(self::BELONGS_TO, 'CatalogProducts', 'releated_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'releated_id' => 'Releated',
			'sort' => 'Sort',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('releated_id',$this->releated_id,true);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsReleated the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getReleatedProducts($id)
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'releated_id';
		$criteria->condition = 'product_id = :product_id';
		$criteria->params = array(':product_id' => $id);
		return self::model()->findAll($criteria);
	}
}
