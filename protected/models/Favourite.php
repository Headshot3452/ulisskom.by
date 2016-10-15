<?php

/**
 * This is the model class for table "favourite_products".
 *
 * The followings are the available columns in table 'favourite_products':
 * @property string $id
 * @property string $user_id
 * @property string $product_id
 *
 * The followings are the available model relations:
 * @property FavouriteProducts $product
 * @property FavouriteProducts[] $favouriteProducts
 * @property Users $user
 */
class Favourite extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'favourite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, item_id, module_id', 'required'),
			array('user_id, item_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, item_id, module_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'user_id' => Yii::t('app','User'),
			'item_id' => Yii::t('app','Item'),
            'module_id' => Yii::t('app','Module'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('item_id',$this->item_id,true);
        $criteria->compare('module_id',$this->module_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FavouriteProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getCountFavouriteForItem($item_id, $module_id)
    {
        return self::model()->count('item_id=:item_id AND module_id=:module_id',
            array(':item_id'=>$item_id, ':module_id'=>$module_id));
    }

    public static function checkFavouriteForUser($item_id, $module_id)
    {
        return self::model()->count('item_id=:item_id AND module_id=:module_id AND user_id=:user_id',
            array(':item_id'=>$item_id, ':module_id'=>$module_id, ':user_id'=>Yii::app()->user->id));
    }

    public static function getFavouritePostId($module_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'module_id=:module_id AND user_id=:user_id';
        $criteria->params = array(':module_id'=>$module_id, ':user_id'=>Yii::app()->user->id);
        $criteria->select = 'item_id';

        $array = array();
        foreach(self::model()->findAll($criteria) as $value)
        {
            $array[] = $value->item_id;
        }
        return $array;
    }
}
