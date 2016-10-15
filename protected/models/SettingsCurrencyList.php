<?php

    /**
     * This is the model class for table "settings_currency_list".
     *
     * The followings are the available columns in table 'settings_currency_list':
     * @property string $name
     * @property string $icon
     * @property integer $basic
     *
     * The followings are the available model relations:
     * @property SettingsCurrency[] $settingsCurrencies
     */

    class SettingsCurrencyList extends Model
    {
        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'settings_currency_list';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('name, icon', 'required'),
                array('basic', 'numerical', 'integerOnly' => true),
                array('name', 'length', 'max' => 50),
                array('name, icon, basic', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'settingsCurrencies' => array(self::HAS_MANY, 'SettingsCurrency', 'currency_name'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'name' => 'Name',
                'icon' => 'Icon',
                'basic' => 'Basic',
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

            $criteria->compare('name', $this->name,true);
            $criteria->compare('icon', $this->icon,true);
            $criteria->compare('basic', $this->basic);

            return new CActiveDataProvider($this,
                array(
                    'criteria'=>$criteria,
                )
            );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsCurrencyList the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public static function getListCurrencyNotBasic()
        {
            $items = self::model()->findAll('basic=:basic', array(':basic'=>0));
            $array = array();
            foreach ($items as $item)
            {
                $array[$item->name] = $item->name;
            }
            return $array;
        }

        public static function getCurrencyBasic()
        {
            $items = self::model()->findAll('basic = :basic', array(':basic' => 1));
            $array = array();
            foreach ($items as $item)
            {
                $array[$item->name] = $item->name;
            }
            return $array;
        }
    }
