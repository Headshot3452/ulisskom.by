<?php
    /**
     * This is the model class for table "settings_currency".
     *
     * The followings are the available columns in table 'settings_currency':
     * @property integer $id
     * @property string $currency_name
     * @property double $course
     * @property integer $format
     * @property integer $format_icon
     * @property integer $status
     *
     * The followings are the available model relations:
     * @property SettingsCurrencyList $currencyName
     */

    class SettingsCurrency extends Model
    {
        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'settings_currency';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('currency_name, course', 'required'),
                array('format, format_icon, status, sort', 'numerical', 'integerOnly'=>true),
                array('course', 'numerical'),
                array('currency_name', 'length', 'max'=>50),
                array('id, currency_name, course, format, format_icon, status', 'safe', 'on'=>'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'currencyName' => array(self::BELONGS_TO, 'SettingsCurrencyList', 'currency_name'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'currency_name' => 'Currency Name',
                'course' => 'Course',
                'format' => 'Format',
                'format_icon' => 'Format Icon',
                'status' => 'Status',
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
            $criteria->compare('currency_name',$this->currency_name,true);
            $criteria->compare('course',$this->course);
            $criteria->compare('format',$this->format);
            $criteria->compare('format_icon',$this->format_icon);
            $criteria->compare('status',$this->status);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsCurrency the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function getFormChild($key, $form)
        {
            if ($key == '')
            {
                $key = $this->id;
            }

            ob_start();

            echo
                '<div class="row one_item">
                    <div class="col-xs-2 no-left">
                        <div class="status active">
                            '.BsHtml::dropDownList('currency['.$key.']', 'currency', SettingsCurrencyList::getListCurrencyNotBasic(), array('empty' => '-', )).'
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="icon">
                            <span></span>
                        </div>
                    </div>
                </div>';

            $form = ob_get_contents();
            ob_end_clean();
            return $form;
        }
    }
