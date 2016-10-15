<?php
    /**
     * This is the model class for table "catalog_products_reviews".
     *
     * The followings are the available columns in table 'catalog_products_reviews':
     * @property string $id
     * @property string $product_id
     * @property string $user_id
     * @property string $create_time
     * @property string $update_time
     * @property integer $status
     * @property integer $rating
     * @property string $header
     * @property string $text
     * @property string $note
     * @property string $fullname
     * @property string $email
     * @property string $phone
     *
     * The followings are the available model relations:
     * @property CatalogProductsReviews $product
     * @property CatalogProductsReviews[] $catalogProductsReviews
     * @property Users $user
     */

    class CatalogProductsReviews extends Model
    {
        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'catalog_products_reviews';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('product_id, status, header, text, fullname, email, phone', 'required'),
                array('status, rating', 'numerical', 'integerOnly' => true),
                array('product_id, user_id, create_time, update_time', 'length', 'max' => 11),
                array('fullname, header', 'length', 'max' => 255),
                array('email', 'length', 'max' => 60),
                array('phone', 'length', 'max' => 30),
                array('sort, note', 'safe'),
                array('id, product_id, user_id, create_time, update_time, status, rating, header, text, note, fullname, email, phone', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'product' => array(self::BELONGS_TO, 'CatalogProductsReviews', 'product_id'),
                'catalogProductsReviews' => array(self::HAS_MANY, 'CatalogProductsReviews', 'product_id'),
                'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
                'user_id' => 'User',
                'create_time' => 'Create Time',
                'update_time' => 'Update Time',
                'status' => 'Status',
                'rating' => 'Rating',
                'header' => Yii::t('app', 'Header'),
                'text' => Yii::t('app', 'Review text'),
                'note' => Yii::t('app', 'Note'),
                'fullname' => 'Fullname',
                'email' => 'Email',
                'phone' => 'Phone',
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

        public function search($model)
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('product_id', $model->id, true);
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('create_time', $this->create_time, true);
            $criteria->compare('update_time', $this->update_time, true);
            $criteria->compare('status', $this->status);
            $criteria->compare('rating', $this->rating);
            $criteria->compare('header', $this->header, true);
            $criteria->compare('text', $this->text, true);
            $criteria->compare('note', $this->note, true);
            $criteria->compare('fullname', $this->fullname, true);
            $criteria->compare('email', $this->email, true);
            $criteria->compare('phone', $this->phone, true);

            $criteria->order = 'sort';

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
         * @return CatalogProductsReviews the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        public static function getRating($key = null)
        {
            $array = array(
                1 => Yii::t('app', 'Horror'),
                2 => Yii::t('app', 'Poorly'),
                3 => Yii::t('app', 'It could be better'),
                4 => Yii::t('app', 'Good'),
                5 => Yii::t('app', 'Excellent'),
                0 => Yii::t('app', 'Not rated'),
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }
    }
