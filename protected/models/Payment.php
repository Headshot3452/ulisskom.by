<?php
    /**
     * This is the model class for table "payment".
     *
     * The followings are the available columns in table 'payment':
     * @property string $id
     * @property string $order_id
     * @property string $organization
     * @property string $director
     * @property string $organization_info
     * @property string $bank_info
     * @property integer $type
     * @property integer $status
     *
     * The followings are the available model relations:
     * @property Orders $order
     */
    class Payment extends Model
    {
        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'payment';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('organization, director, organization_info, bank_info, type', 'required'),
                array('type, status', 'numerical', 'integerOnly' => true),
                array('status', 'default', 'value'  =>  self::STATUS_OK, 'on'  =>  'insert'),
                array('order_id', 'length', 'max' => 11),
                array('organization, director', 'length', 'max' => 100),
                array('organization_info, bank_info', 'length', 'max' => 255),
                array('id, order_id, organization, director, organization_info, bank_info, type, status', 'safe', 'on'=>'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'order_id' => 'Order',
                'organization' => Yii::t('app', 'Organization'),
                'director' => Yii::t('app', 'Director'),
                'organization_info' => Yii::t('app', 'Details of the organization'),
                'bank_info' => Yii::t('app', 'Bank details of the organization'),
                'type' => 'Type',
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
            $criteria=new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('order_id', $this->order_id, true);
            $criteria->compare('organization', $this->organization, true);
            $criteria->compare('director', $this->director, true);
            $criteria->compare('organization_info', $this->organization_info, true);
            $criteria->compare('bank_info', $this->bank_info, true);
            $criteria->compare('type', $this->type);
            $criteria->compare('status', $this->status);

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
         * @return Payment the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }
    }
