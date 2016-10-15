<?php
    /**
     * This is the model class for table "address".
     *
     * The followings are the available columns in table 'address':
     * @property string $id
     * @property string $user_id
     * @property string $city
     * @property string $street
     * @property string $house
     * @property string $apartment
     * @property string $user_name
     * @property string $phone
     * @property integer $default
     *
     * The followings are the available model relations:
     * @property Users $user
     * @property Orders[] $orders
     */

    class Address extends Model
    {
        const ADDRESS_DEFAULT = 1;
        const ADDRESS_NOT_DEFAULT = 0;

        private $_count_default = 0;

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'address';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('city, street, house, user_name, phone, country', 'required'),
                array('default, index', 'numerical', 'integerOnly'=>true),
                array('user_id', 'length', 'max'=>10),
                array('street, city', 'length', 'max'=>127),
                array('house', 'length', 'max'=>15),
                array('apartment', 'length', 'max'=>7),
                array('user_name', 'length', 'max'=>128),
                array('phone', 'length', 'max'=>64),
                array('id, user_id, city, street, house, apartment, user_name, phone, default', 'safe', 'on'=>'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
                'orders' => array(self::HAS_MANY, 'Orders', 'address_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'user_id' => 'User',
                'city' => Yii::t('app', 'City'),
                'street' => Yii::t('app', 'Street'),
                'house' => Yii::t('app', 'House'),
                'apartment' => Yii::t('app', 'Apartment'),
                'user_name' => Yii::t('app', 'Contact name'),
                'phone' => Yii::t('app', 'Phone'),
                'default' => Yii::t('app', 'Default'),
                'country' => Yii::t('app', 'Country'),
                'index' => Yii::t('app', 'Index'),
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
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('city', $this->city_id, true);
            $criteria->compare('street', $this->street, true);
            $criteria->compare('house', $this->house, true);
            $criteria->compare('apartment', $this->apartment, true);
            $criteria->compare('user_name', $this->user_name, true);
            $criteria->compare('phone', $this->phone, true);

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        public function afterSave()
        {
            parent::afterSave();

            if(is_null($this->user_id))
            {
                throw new Exception('user_id is required');
            }

            //если умолчаний больше чем 1, то дропаем все кроме текущего

            if($this->default == self::ADDRESS_DEFAULT && $this->_count_default >= 1)
            {
                $this->getDbConnection()->createCommand()->update($this->tableName(), array("default" => self::ADDRESS_NOT_DEFAULT), "`id` != :id", array(":id" => $this->id));
            }
        }

        public function beforeSave()
        {
            parent::beforeSave();

            if(is_null($this->user_id)) throw new Exception('user_id is required');

            $this->_count_default = $this->count("`default` = :default AND `user_id` = :user_id",array(':default' => self::ADDRESS_DEFAULT, ':user_id' => $this->user_id));

            //если не было адресов по умолчанию

            if(!$this->_count_default)
            {
                $this->default = self::ADDRESS_DEFAULT;
            }

            return true;
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return Address the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public static function getUserAddress($user_id)
        {
            return self::model()->active()->findAllByAttributes(array('user_id' => $user_id));
        }

        public static function getAddressForUser($id,$user_id)
        {
            return self::model()->active()->findByAttributes(array('user_id' => $user_id, 'id' => $id));
        }

    }