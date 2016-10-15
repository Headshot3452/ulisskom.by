<?php
    /**
     * This is the model class for table "order_payments".
     *
     * The followings are the available columns in table 'order_payments':
     * @property string $id
     * @property string $order_id
     * @property string $user_id
     * @property string $currency_id
     * @property string $create_time
     * @property string $update_time
     * @property integer $status
     * @property string $pay_system
     * @property string $pay_num
     * @property string $account
     * @property string $recipient
     * @property double $summa
     * @property string $text
     *
     * The followings are the available model relations:
     * @property Orders $order
     * @property SettingsCurrencyList $currency
     * @property Users $user
     */

    class OrderPayments extends Model
    {
        const ORDER_PAID = 1;
        const ORDER_WAIT = 2;
        const ORDER_OVERDUE = 3;
        const ORDER_CANCELED = 4;

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'order_payments';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('order_id, status, pay_system, pay_num, account, recipient, summa, text', 'required'),
                array('status', 'numerical', 'integerOnly' => true),
                array('summa', 'numerical'),
                array('order_id, user_id, create_time, update_time', 'length', 'max' => 11),
                array('currency_id', 'length', 'max' => 50),
                array('pay_system, recipient', 'length', 'max' => 60),
                array('pay_num, account', 'length', 'max' => 20),
                array('id, order_id, user_id, currency_id, create_time, update_time, status, pay_system, pay_num, account, recipient, summa, text', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
                'currency' => array(self::BELONGS_TO, 'SettingsCurrencyList', 'currency_id'),
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
                'order_id' => 'Order',
                'user_id' => 'User',
                'currency_id' => 'Currency',
                'create_time' => 'Create Time',
                'update_time' => 'Update Time',
                'status' => 'Status',
                'pay_system' => 'Pay System',
                'pay_num' => 'Pay Num',
                'account' => 'Account',
                'recipient' => 'Recipient',
                'summa' => 'Summa',
                'text' => 'Text',
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

        public function search($count)
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('order_id', $this->order_id, true);
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('currency_id', $this->currency_id, true);
            $criteria->compare('create_time', $this->create_time, true);
            $criteria->compare('update_time', $this->update_time, true);
            $criteria->compare('status', $this->status);
            $criteria->compare('pay_system', $this->pay_system, true);
            $criteria->compare('pay_num', $this->pay_num, true);
            $criteria->compare('account', $this->account, true);
            $criteria->compare('recipient', $this->recipient, true);
            $criteria->compare('summa', $this->summa);
            $criteria->compare('text', $this->text, true);

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => $count,
                        'pageVar' => 'page',
                    )
                )
            );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return OrderPayments the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        public function getAdminPaymentsProvider($count, $date_from, $date_to, $sort, $order)
        {
            $criteria = new CDbCriteria();

            $params = array();

            if($date_from)
            {
                $criteria->addCondition('t.create_time > :date_from');
                $params[':date_from'] = $date_from;
            }

            if($date_to)
            {
                $criteria->addCondition('t.create_time < :date_to');
                $params[':date_to'] = $date_to;
            }

            if($status = Yii::app()->request->getParam('status'))
            {
                $criteria->addCondition('t.status = :status');
                $params[':status'] = $status;
            }

            if(isset($params))
            {
                $criteria->params = $params;
            }

            $criteria->order = $sort.' '.$order;

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => $count,
                        'pageVar' => 'page',
                    )
                )
            );
        }

        public static function getStatus($key = null)
        {
            $array = array(
                self::ORDER_PAID => 'Оплачен',
                self::ORDER_WAIT => 'В ожидании',
                self::ORDER_OVERDUE => 'Просрочен',
                self::ORDER_CANCELED => 'Отменен',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }
    }