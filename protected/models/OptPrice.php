<?php

/**
 * This is the model class for table "opt_price".
 *
 * The followings are the available columns in table 'opt_price':
 * @property string $id
 * @property string $product_id
 * @property double $opt_price
 * @property integer $opt_count
 * @property integer $opt_count_from
 * @property string $opt_text
 *
 * The followings are the available model relations:
 * @property CatalogProducts $product
 */
class OptPrice extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'opt_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('opt_price, opt_count, opt_count_from', 'required'),
            array('opt_count, opt_count_from', 'compare', 'operator'=>'>', 'compareValue' => '0'),
			array('id, product_id', 'length', 'max'=>10),
			array('opt_text', 'length', 'max'=>60),
            array('product_id', 'safe'),
			array('id, product_id, opt_price, opt_count, opt_count_from, opt_text', 'safe', 'on'=>'search'),
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
			'opt_price' => Yii::t('app', 'Opt Price'),
			'opt_count' => 'Opt Count',
			'opt_count_from' => 'Opt Count From',
			'opt_text' => 'Opt Text',
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
		$criteria->compare('opt_price',$this->opt_price);
		$criteria->compare('opt_count',$this->opt_count);
		$criteria->compare('opt_count_from',$this->opt_count_from);
		$criteria->compare('opt_text',$this->opt_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OptPrice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getValueForm($key, $form, $ico)
    {
        echo
            '<div class="row item">
                <div class="col-xs-3 opt_price_cont">
                    '.$form->textField($this, '['.$key.']opt_price', array('placeholder' => '', 'class' => 'integer')).'
                    <span>
                        '.$ico.'
                    </span>
                </div>
                <div class="col-xs-2 count_container">
                    '.$form->textField($this, '['.$key.']opt_count', array('placeholder' => '', 'class' => 'integer')).'
                    <span>
                        шт
                    </span>
                </div>
                <div class="col-xs-2 count_container">
                    '.$form->textField($this, '['.$key.']opt_count_from', array('placeholder' => '')).'
                    <span>
                        шт
                    </span>
                </div>
                <div class="col-xs-4 text_cont">
                    '.$form->textField($this, '['.$key.']opt_text', array('placeholder' => '')).'
                </div>
                <a href="javascript:void(0)" class="del-form"><span class="icon-admin-delete"></span></a>
            </div>';
    }
}
