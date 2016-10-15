<?php
    /**
     * This is the model class for table "order_items".
     *
     * The followings are the available columns in table 'order_items':
     * @property string $id
     * @property string $product_id
     * @property string $order_id
     * @property string $title
     * @property integer $price
     * @property integer $count
     * @property integer $count_edit
     * @property integer $discount
     * @property integer $status
     * @property integer $product_type_add
     *
     * The followings are the available model relations:
     * @property Orders $order
     * @property CatalogProducts $product
     */

    class OrderItems extends Model
    {
        const USER_ADD_PRODUCT = 0;
        const ADMIN_ADD_PRODUCT = 1;

         /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'order_items';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('order_id, title, price', 'required'),
                array('status', 'default', 'value' => self::STATUS_OK),
                array('product_type_add', 'default', 'value' => self::USER_ADD_PRODUCT),
                array('count', 'required','on' => 'insert'),
                array('count', 'unsafe', 'on' => 'update'),
                array('count_edit', 'unsafe', 'on' => 'insert'),
                array('count, count_edit, status, product_type_add', 'numerical', 'integerOnly' => true),
                array('product_id, order_id', 'length', 'max' => 10),
                array('title', 'length', 'max' => 255),
                array('discount', 'numerical'),
                array('id, product_id, order_id, title, price, count, count_edit, discount, status, product_type_add', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
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
                'order_id' => 'Order',
                'title' => 'Title',
                'price' => 'Price',
                'count' => 'Count',
                'discount' => 'Discount',
                'count_edit' => 'Count Edit',
                'status' => 'Status',
                'product_type_add' => 'Product Type Add',
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
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('product_id', $this->product_id, true);
            $criteria->compare('order_id', $this->order_id, true);
            $criteria->compare('title', $this->title, true);
            $criteria->compare('price', $this->price);
            $criteria->compare('count', $this->count);
            $criteria->compare('count_edit', $this->count_edit);
            $criteria->compare('discount', $this->discount);
            $criteria->compare('status', $this->status);
            $criteria->compare('product_type_add', $this->product_type_add);

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return OrderItems the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }


        public static function getStatus($key = null)
        {
            $array = array(
                self::STATUS_OK => 'В наличии',
                self::STATUS_NOT_ACTIVE => 'Отсутствует',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public function getCount()
        {
            return $this->count + $this->count_edit;
        }

        public function getItemPrice()
        {
            return $this->getCount() * $this->price;
        }

        public function getItemDiscount()
        {
            return $this->getCount() * $this->discount;
        }

        public function getPrice()
        {
            return $this->price;
        }

        public function getSum()
        {
            return $this->getCount() * $this->getPrice();
        }
    }