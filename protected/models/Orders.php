<?php
    /**
     * This is the model class for table "orders".
     *
     * The followings are the available columns in table 'orders':
     * @property string $id
     * @property string $user_id
     * @property string $address_id
     * @property string $manager_id
     * @property string $executor_id
     * @property string $picker_id
     * @property string $address_text
     * @property string $count
     * @property string $sum
     * @property double $sum_delivery
     * @property string $comment
     * @property integer $type_delivery
     * @property integer $type_payments
     * @property string $delivery_time
     * @property string $delivery_hours
     * @property integer $paid
     * @property integer $status
     * @property integer $create_time
     * @property integer $update_time
     * @property string $info
     *
     * The followings are the available model relations:
     * @property OrderItems[] $orderItems
     * @property Workers $picker
     * @property Address $address
     * @property Users $user
     * @property Workers $executor
     * @property Users $manager
     */

    class Orders extends Model
    {
        const STATUS_NOT_DELIVERED = -3; //не доставлено
        const STATUS_RETURNED = -2; //возврат
        const STATUS_CANCELLED = -1; //отменен
        const STATUS_DELETED = 0; //удален
        const STATUS_OK = 1; //принят
        const STATUS_PROCESSING = 2; //в обработке
        const STATUS_STAFFED = 3; //укомплетован
        const STATUS_DELIVERING = 4; //доставляется
        const STATUS_COMPLETED = 5; //выполнен

        const ORDER_NOT_PAID = 0;
        const ORDER_PAID = 1;
        const ORDER_PARTIALLY = 2;
        const ORDER_EXCEEDED = 3;

        const ORDER_DELIVERY_NOT_ADDRESS    = 1; // Самовывоз
        const ORDER_DELIVERY_TO_ADDRESS     = 2; // Доставка по адресу
        const ORDER_DELIVERY_TO_POST        = 3; // Доставка почтой

        const ORDER_PAYMENT_CASH        = 1; // Наличные
        const ORDER_PAYMENT_CASHLESS    = 2; // Безналичный расчёт

        //форматированные данные

        public $f_create_time = '';
        public $f_update_time = '';
        public $f_delivery_time = '';
        public $f_sum = '';
        public $f_sum_paid = '';
        public $f_delivery_end = '';

        //расписание часов доставки

        protected $_delivery_schedule = array(
            '00:00-02:00',
            '02:00-04:00',
            '04:00-06:00',
            '06:00-08:00',
            '08:00-10:00',
            '10:00-12:00',
            '12:00-14:00',
            '14:00-16:00',
            '16:00-18:00',
            '18:00-20:00',
            '20:00-22:00',
            '22:00-24:00',
        );

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'orders';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('count, sum, type_delivery, type_payments, status', 'required'),
                array('type_delivery, type_payments, paid, status', 'numerical', 'integerOnly' => true),
                array('sum_delivery, sum_paid', 'numerical'),
                array('user_id, address_id, manager_id, executor_id, picker_id, count, sum, create_time, update_time, delivery_time', 'length', 'max' => 10),
                array('delivery_hours', 'length', 'max' => 16),
                array('address_text, comment, note1, note2, note3, note4', 'safe'),
                array('id, user_id, address_id, manager_id, executor_id, paid, picker_id, address_text, count, sum, comment, type_delivery, type_payments, create_time, update_time, delivery_time, delivery_hours, status', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'orderItems' => array(self::HAS_MANY, 'OrderItems', 'order_id', 'scopes' => array('notDeleted')),
                'manager' => array(self::BELONGS_TO, 'Users', 'manager_id'),
                'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
                'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
                'executor' => array(self::BELONGS_TO, 'Workers', 'executor_id'),
                'picker' => array(self::BELONGS_TO, 'Workers', 'picker_id'),
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
                'address_id' => 'Address',
                'manager_id' => 'Manager',
                'executor_id' => 'Executor',
                'picker_id' => 'Picker',
                'address_text' => 'Address Text',
                'count' => 'Count',
                'sum' => Yii::t('app', 'Sum'),
                'sum_paid' => Yii::t('app', 'Paid amount'),
                'sum_delivery' => 'Sum Delivery',
                'comment' => 'Comment',
                'type_delivery' => 'Type Delivery',
                'type_payments' => Yii::t('app', 'Type Payments'),
                'create_time' => 'Create Time',
                'update_time' => 'Update Time',
                'delivery_time' => 'Delivery Time',
                'delivery_hours' => 'Delivery Hours',
                'paid' => 'Paid',
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
            $criteria = new CDbCriteria;
            $criteria->compare('id', $this->id, true);
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('address_id', $this->address_id, true);
            $criteria->compare('manager_id', $this->manager_id, true);
            $criteria->compare('executor_id', $this->executor_id, true);
            $criteria->compare('picker_id', $this->picker_id, true);
            $criteria->compare('address_text', $this->address_text, true);
            $criteria->compare('count', $this->count, true);
            $criteria->compare('sum', $this->sum, true);
            $criteria->compare('sum_delivery', $this->sum_delivery);
            $criteria->compare('comment', $this->comment, true);
            $criteria->compare('type_delivery', $this->type_delivery);
            $criteria->compare('type_payments', $this->type_payments);
            $criteria->compare('create_time', $this->create_time, true);
            $criteria->compare('update_time', $this->update_time, true);
            $criteria->compare('delivery_time', $this->delivery_time, true);
            $criteria->compare('delivery_hours', $this->delivery_hours, true);
            $criteria->compare('paid', $this->paid);
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
         * @return Orders1 the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        public function init()
        {
            parent::init();

            $this->onNewOrder = array('CoreEvents', 'onNewOrder');
        }

        public function onNewOrder($event)
        {
            $this->raiseEvent('onNewOrder', $event);
        }

        protected function afterFind()
        {
            parent::afterFind();

            $this->f_create_time = Yii::app()->dateFormatter->format('dd.MM.yyyy, hh:mm', $this->create_time);

            $formatter = new CFormatter;
            $formatter->numberFormat = array('decimals' => '2', 'decimalSeparator'=>'.', 'thousandSeparator' => ' ');

            $this->f_sum = $formatter->number($this->sum); //сумма заказа
            $this->f_sum_paid = (isset($this->sum_paid)) ? $formatter->number($this->sum_paid) : 0; //сумма оплаты

            $this->f_delivery_time = Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->delivery_time); //время доставки
            if($this->f_delivery_time == Yii::app()->dateFormatter->format('dd.MM.yyyy', time()))
            {
                $this->f_delivery_time = 'Сегодня';
            }

            //время обновления статуса

            if($this->update_time)
            {
                $this->f_update_time = Yii::app()->dateFormatter->format('dd.MM.yyyy, hh:mm', $this->update_time);
            }

            if($this->status != self::STATUS_COMPLETED && $this->status > 0)
            {
                $sec = $this->delivery_time - time();
                $days = round($sec / 86400);
                $hours = abs(round(($sec % 86400) / 3600));
                $min = abs(round((($sec % 86400) % 3600) / 60));
                $this->f_delivery_end = $days.' д. '.$hours.':'.$min.' мин.';
            }

        }

        public function beforeSave()
        {
            parent::beforeSave();

            return true;
        }

        public function afterSave()
        {
            parent::afterSave();

            if (!empty($this->orderItems))
            {
                foreach($this->orderItems as $item)
                {
                    $item->order_id = $this->id;
                    $item->save();
                }
            }

            if ($this->isNewRecord || $this->scenario == 'insert')
            {
                if ($this->hasEventHandler('onNewOrder'))
                {
                    $event= new CModelEvent($this);
                    $this->onNewOrder($event);
                }
            }
        }

        public function behaviors()
        {
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'create_time',
                    'updateAttribute' => 'update_time',
                ),
            );
        }

        public static function getOrders($user_id, $days = null)
        {
            $cond = 'user_id = :user_id ';
            $params = array(':user_id' => $user_id);

            if(!is_null($days) && is_numeric($days))
            {
                $date = time() - $days * 86400;
                $cond .= ' AND create_time>'.$date;
            }

            return self::model()->findAll(array('condition' => $cond, 'order' => 'id DESC', 'params' => $params));
        }

        public static function getOrdersProvider($user_id, $days=null)
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition('user_id = :user_id');
            $params= array(':user_id' => $user_id);

            if(!is_null($days) && is_numeric($days))
            {
                $date = time() - $days * 86400;
                $criteria->addCondition('create_time > :create_time');
                $params[':create_time'] = $date;
            }

            $criteria->params = $params;
            $criteria->order = 'id DESC';

            $page = isset($_GET['page']) ? CHtml::encode($_GET['page']) : 0;

            $currentPage = ($page != 0 && $page != 1) ? $page : 0;

            return new CActiveDataProvider(new self,
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
//                        'pageSize' => $count,
                        'pageVar'  => 'page',
                    ),
                )
            );
        }

        public static function getAdminOrdersProvider($pagesize = 15, $user_id = '', $status = '', $manager_id = '', $worker_id = '', $date_from = '', $date_to = '', $sort = 't.id', $order = 'DESC')
        {
            $criteria = new CDbCriteria();

            $criteria->with = array('user.user_info', 'picker', 'executor', 'manager.user_info' => array('alias' => 'user_info1'));

            if($user_id)
            {
                $criteria->addCondition('t.user_id = :user_id');
                $params = array(':user_id' => $user_id);
            }

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

            if($status)
            {
                $criteria->addCondition('t.status = :status');
                $params[':status'] = $status;
            }

            if($worker_id)
            {
                $criteria->addCondition('(t.picker_id = :worker_id OR t.executor_id = :worker_id)');
                $params[':worker_id'] = $worker_id;
            }

            if($manager_id)
            {
                $criteria->addCondition('t.manager_id = :manager_id');
                $params[':manager_id'] = $manager_id;
            }

            if(isset($params))
            {
                $criteria->params = $params;
            }

            $criteria->order = $sort.' '.$order;

            return new CActiveDataProvider(self::model(),
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => $pagesize,
                        'pageVar' => 'page',
                    )
                )
            );
        }

        public static function getStatusForFilter($key = null)
        {
            $array = array(
                self::STATUS_NOT_DELIVERED => '<div class="order-status-3"></div>Не доставлен',
                self::STATUS_RETURNED => '<div class="order-status-2"></div>Возврат',
                self::STATUS_CANCELLED => '<div class="order-status-1"></div>Отменен',
                self::STATUS_DELETED => '<div class="order-status0"></div>Удален',
                self::STATUS_OK => '<div class="order-status1"></div>Принят',
                self::STATUS_PROCESSING => '<div class="order-status2"></div>В обработке',
                self::STATUS_STAFFED => '<div class="order-status3"></div>Укомплектован',
                self::STATUS_DELIVERING => '<div class="order-status4"></div>В процессе доставки',
                self::STATUS_COMPLETED => '<div class="order-status5"></div>Выполнен',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public static function createOrder($user_id, $products)
        {
            $count = 0;
            $sum = 0;
            $orderItems = array();

            $order = new self;
            $order->user_id = $user_id;

            $order->type_payments = $_POST['payment_type'];
            $order->type_delivery =  $_POST['delivery_type'];

            if ($order->type_delivery == self::ORDER_DELIVERY_TO_ADDRESS || $order->type_delivery == self::ORDER_DELIVERY_TO_POST)
            {
                if($user_id)
                {
                    $address_id = Address::model()->find('user_id = :user_id AND `default` = 1', array('user_id' => $user_id));
                    $order->address_id = $address_id->id;
                }

                $order->address_text = serialize($_POST['Address']);
            }

            $order->comment = isset($_POST['user_comment']) ? $_POST['user_comment'] : '';
            $order->delivery_time = isset($_POST['date']) ? strtotime($_POST['date']) : '';
            $order->delivery_hours = isset($_POST['time']) ? ($_POST['time']) : '';
            $order->delivery_comment = isset($_POST['delivery_comment']) ? ($_POST['delivery_comment']) : '';

            $order->user_info = serialize(array_merge($_POST['Users'], $_POST['UserInfo']));

            foreach($products as $product)
            {
                $order_item = $order->getInstanceRelation('orderItems');
                $order_item->product_id = $product['id'];
                $order_item->title = $product['title'];
                $order_item->price = $product['price'];
                $order_item->count = $product['count'];
                $order_item->discount = $product['sale'];

                $sum += ($order_item->discount) ? $order_item->getItemDiscount() : $order_item->getItemPrice();
                $count += $order_item->getCount();

                $orderItems[] = $order_item;
            }
            $order->orderItems = $orderItems;

            $order->count = $count;
            $order->sum = $sum;
            $order->status = self::STATUS_OK;

            if($order->save())
            {
                return $order;
            }
            return false;
        }

        public static function getTypeDelivery($key = null)
        {
            $array = array(
                self::ORDER_DELIVERY_NOT_ADDRESS => 'Самовывоз',
                self::ORDER_DELIVERY_TO_ADDRESS => 'Доставка по указаному адресу',
                self::ORDER_DELIVERY_TO_POST => 'Доставка почтой',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public static function getTypePayment($key = null)
        {
            $array = array(
                self::ORDER_PAYMENT_CASH => 'Наличные',
                self::ORDER_PAYMENT_CASHLESS => 'Безналичный расчёт',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public static function getPaid($key = null)
        {
            $array = array(
                self::ORDER_PAID => 'Оплачен',
                self::ORDER_NOT_PAID => 'Не Оплачен',
                self::ORDER_PARTIALLY => 'Оплачен частично',
                self::ORDER_EXCEEDED => 'Сумма превышена',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public static function getStatus($key = null)
        {
            $array = array(
                self::STATUS_NOT_DELIVERED => 'Не доставлен',
                self::STATUS_RETURNED => 'Возврат',
                self::STATUS_CANCELLED => 'Отменен',
                self::STATUS_DELETED => 'Удален',
                self::STATUS_OK => 'Принят',
                self::STATUS_PROCESSING => 'В обработке',
                self::STATUS_STAFFED => 'Укомплектован',
                self::STATUS_DELIVERING => 'В процессе доставки',
                self::STATUS_COMPLETED => 'Выполнен',
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public static function getDeliveryPrice()
        {
            return 70000;
        }

        public static function getDeliverySchedule()
        {
            return array_combine(self::model()->_delivery_schedule, self::model()->_delivery_schedule);
        }

        public static function getDeliveryLimit()
        {
            return 200000;
        }


    }
