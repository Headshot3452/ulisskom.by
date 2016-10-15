<?php
    /**
     * This is the model class for table "users".
     *
     * The followings are the available columns in table 'users':
     * @property string $id
     * @property string $login
     * @property string $password
     * @property string $email
     * @property integer $role
     * @property string $avatar
     * @property integer $create_time
     * @property integer $update_time
     * @property integer $status
     *
     * The followings are the available model relations:
     * @property Structure[] $structures
     */

    class Users extends Model
    {
        const PathAvatar = 'data/users/avatar/';

        const STATUS_BANNED = 4;

        const ROLE_ALL = 0;
        const ROLE_DEV = 1;
        const ROLE_ADMIN = 2;
        const ROLE_MODER = 3;
        const ROLE_USER = 4;
        const ROLE_MANAGER = 5;
        const ROLE_SEO = 6;

        public $item_file = '';
        public $_oldPass;

        public $new_email;
        public $new_password;

        public $password_confirm;

        public $captcha;

        protected $_full_name = '';

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return Users the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'users';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('login, email, new_email', 'filter', 'filter' => 'trim'),
                array('login, role, status', 'required', 'on' => 'insert, update'),
                array('email', 'unique','on' => 'settings_user, register_admin'),
                array('last_ip', 'safe'),
                array('role', 'safe', 'on' => 'settings_user, register_admin'),
                array('item_file', 'safe', 'on' => 'update, update_avatar, settings_user'),
                array('item_file, avatar', 'unsafe', 'on' => 'update_status, login'),
                array('role', 'default','value' => self::ROLE_USER),
                array('status', 'default', 'value' => self::STATUS_NOT_ACTIVE),
                array('login, email', 'unique','on'=>'insert, update, update_password, register'),
                array('new_email', 'unique', 'attributeName' => 'email', 'on' => 'change_email'),
                array('email', 'required', 'on'=>'insert, update, register, login, userfront_check, settings_user, register_admin'),
                array('password', 'required', 'on'=>'login, change_email, settings_user, register_admin'),
                array('password, password_confirm', 'required', 'on' => 'insert, update, update_password, password_reset, register'),
                array('password_confirm', 'compare', 'compareAttribute' => 'password', 'on' => 'insert, update, update_password, password_reset, register, register_admin'),
                array('password', 'authenticate', 'on' => 'login, change_password, change_email'),
                array('role, create_time, update_time, status', 'numerical', 'integerOnly' => true),
                array('login', 'length', 'max' => 50),
                array('password', 'length', 'max' => 70),
                array('email', 'length', 'max' => 100),
                array('email', 'email', 'on' => 'insert, register, update, user_check, userfront_check, settings_user'),
                array('new_email', 'required', 'on' => 'change_email'),
                array('new_email', 'email', 'on' => 'change_email'),
                array('new_password, password, password_confirm', 'required', 'on' => 'change_password'),
                array('password_confirm', 'compare', 'compareAttribute'=>'new_password','on'=>'change_password'),
                array('captcha', 'captcha', 'allowEmpty' => !Yii::app()->user->issetCaptcha() || !CCaptcha::checkRequirements(), 'on' => 'user_check, register'),
                array('id, login, password, email, role, avatar, create_time, update_time, status', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'structures' => array(self::HAS_MANY, 'Structure', 'author_id'),
                'addresses' => array(self::HAS_MANY, 'Address', 'user_id'),
                'news' => array(self::HAS_MANY, 'News', 'author_id'),
                'user_info' => array(self::HAS_ONE, 'UserInfo', 'user_id'),
                'user_setting' => array(self::HAS_ONE, 'UserSettings', 'user_id'),
                'usersCheckActions' => array(self::HAS_MANY, 'UsersCheckAction', 'user_id'),
                'usersSession' => array(self::HAS_ONE, 'UsersSessions', 'user_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'login' => Yii::t('app', 'Login user'),
                'password' => Yii::t('app', 'CreatePassword'),
                'email' => Yii::t('app', 'E-mail:'),
                'role' => Yii::t('app', 'Role'),
                'avatar' => Yii::t('app', 'Avatar'),
                'create_time' => Yii::t('app', 'Create Time'),
                'update_time' => Yii::t('app', 'Update Time'),
                'status' => Yii::t('app', 'Status'),
                'captcha' => Yii::t('app', 'Captcha'),
                'password_confirm' => Yii::t('app', 'Password confirm'),
                'new_email' => Yii::t('app', 'New Email'),
                'new_password' => Yii::t('app', 'New password'),
                'password_confirm' =>  Yii::t('app', 'Password confirm'),
            );
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */

        public function search($page_size)
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', '> 1', true);
            $criteria->compare('login', $this->login, true);
            $criteria->compare('password', $this->password, true);
            $criteria->compare('email', $this->email, true);
            $criteria->compare('role', $this->role);
            $criteria->compare('avatar', $this->avatar, true);
            $criteria->compare('create_time', $this->create_time);
            $criteria->compare('update_time', $this->update_time);
            $criteria->compare('status', $this->status);

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination'=>array(
                        'pageSize'=>$page_size,
                        'pageVar'=>'page',
                    ),
                )
            );
        }

        public function init()
        {
            parent::init();

            $this->onUserRegister = array('CoreEvents', 'onUserRegister');
        }

        public function onUserRegister($event)
        {
            $this->raiseEvent('onUserRegister', $event);
        }

        public function behaviors()
        {
            return array(
                    'CTimestampBehavior' => array(
                        'class' => 'zii.behaviors.CTimestampBehavior',
                        'createAttribute' => 'create_time',
                        'updateAttribute' => 'update_time',
                    ),
                    'ImageBehavior' => array(
                        'class' => 'application.behaviors.ImageBehavior',
                        'path' => self::PathAvatar,
                        'files_attr_model' => 'avatar',
                        'sizes' => array('small' => array('140', '140'), 'original' => array(null, null)),
                        'quality' => 100
                     ),
                );
        }

        public function authenticate($attribute,$params)
        {
            if(!$this->hasErrors())
            {
                $identity = new UserIdentity($this->email, $this->password);
                $identity->authenticate();
                switch($identity->errorCode)
                {
                    case UserIdentity::ERROR_NONE:
                    {
                        Yii::app()->user->login($identity, 3000);
                        break;
                    }
                    case UserIdentity::ERROR_USERNAME_INVALID:
                    {
                        $this->addError('email', Yii::t('app', 'This user does not exist!'));
                        break;
                    }
                    case UserIdentity::ERROR_PASSWORD_INVALID:
                    {
                        $this->addError('password', Yii::t('app', 'You have entered an invalid password!'));
                        break;
                    }
                    case '3':
                    {
                        $this->addError('email', Yii::t('app', 'You can not login. Please contact the site administrator!'));
                        break;
                    }
                }
            }
        }

        public static function getStatus($key=null)
        {
            $array = CMap::mergeArray(
                parent::getStatus(),
                array(
                    self::STATUS_BANNED => Yii::t('app', 'Banned')
                )
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public function banned()
        {
            $array = $this->getCriteriaAlias();
            $array['criteria']->mergeWith(
                array(
                    'condition' => '`'.$array['alias'].'`.`status` = '.self::STATUS_BANNED
                )
            );
            return $this;
        }

        public static function getRole($key=null)
        {
            $array = array(
                self::ROLE_DEV => Yii::t('app', 'Developer'),
                self::ROLE_ADMIN => Yii::t('app', 'Administrator'),
                self::ROLE_MODER => Yii::t('app', 'Moderator'),
                self::ROLE_USER => Yii::t('app', 'User'),
                self::ROLE_MANAGER => Yii::t('app', 'Manager'),
                self::ROLE_SEO => Yii::t('app', 'Content manager'),
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public static function getRoleForFilter($key=null)
        {
            $array = array(
                self::ROLE_ALL => Yii::t('app', 'All'),
                self::ROLE_DEV => Yii::t('app', 'Developer'),
                self::ROLE_ADMIN => Yii::t('app', 'Administrator'),
                self::ROLE_MODER => Yii::t('app', 'Moderator'),
                self::ROLE_USER => Yii::t('app', 'User'),
                self::ROLE_MANAGER => Yii::t('app', 'Manager'),
                self::ROLE_SEO => Yii::t('app', 'Content manager'),
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        function getOldPass()
        {
            return $this->_oldPass;
        }

        function setOldPass($pass)
        {
            $this->_oldPass = $pass;
        }

        public function validatePassword($password)
        {
            return CPasswordHelper::verifyPassword($password, $this->password);
        }

        public function beforeSave()
        {
            if (parent::beforeSave())
            {
                if($this->isNewRecord || $this->scenario == 'update_password' ||
                    $this->scenario == 'change_password' || $this->scenario == 'insert' ||
                    $this->scenario == 'password_reset')
                {
                    $this->password = CPasswordHelper::hashPassword($this->password);
                }
                return true;
            }
            return false;
        }

        public function afterSave()
        {
            parent::afterSave();

            if ($this->isNewRecord || $this->scenario == 'insert') //так как user может до регестрироваться scenario='insert'
            {
                if (!isset($this->user_info)) //если вдруг нет user_info то создать, просто пустую запись в базе
                {
                    $this->user_info = $this->getInstanceRelation('user_info');
                }
                if (!isset($this->user_setting)) //если вдруг нет user_setting то создать, просто пустую запись в базе
                {
                    $this->user_setting = $this->getInstanceRelation('user_setting');
                }
                if (!isset($this->addresses)) //если вдруг нет addresses то создать, просто пустую запись в базе
                {
                    $this->addresses = $this->getInstanceRelation('addresses');
                }

                $this->user_info->scenario = 'user_create'; //упращенная валидация
                $this->user_info->user_id = $this->id;
                $this->user_info->nickname = preg_replace( '/@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/', '', $this->email);
                $this->user_info->save();


                $this->user_setting->user_id = $this->id;
                $this->user_setting->save();

                $this->addresses->user_id = $this->id;
                $this->addresses->save();

                if ($this->hasEventHandler('onUserRegister'))
                {
                    $event = new CModelEvent($this);
                    $this->onUserRegister($event);
                }
            }
        }

        public function setFullName($name)
        {
            $this->_full_name = $name;
        }

        public function getFullName()
        {
            if (empty($this->_full_name) && is_object($this->user_info))
            {
                $this->_full_name = $this->user_info->getFullName();
            }
            return $this->_full_name;
        }

        public function getDataProviderForUsers($model, $count)
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', '<>1', false);


            if($model->email != '')
            {
                $criteria->compare('email', $model->email, true);
            }
            if($model->status != 0)
            {
                $criteria->compare('status', $model->status, true);
            }
            if($model->role != 0)
            {
                $criteria->compare('role', $model->role, false);
            }
            if($model->create_time != 0)
            {
                $start_time = strtotime($model->create_time);
                $end_time = strtotime($model->create_time.'23:59:59');

                $criteria->compare('create_time', '>='.$start_time, false);
                $criteria->compare('create_time', '<='.$end_time, false);
            }
            if ($model->update_time != 0)
            {
                $start_time = strtotime($model->update_time);
                $end_time = strtotime($model->update_time.'23:59:59');

                $criteria->compare('update_time', '>='.$start_time, false);
                $criteria->compare('update_time', '<='.$end_time, false);
            }

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => $count
                    ),
                )
            );
        }

        public static function getUserList($author = array())
        {
            if(empty($author))
            {
                $users = Users::model()->active()->findAll('id <> 1');
            }
            elseif(is_array($author) && !empty($author))
            {
                $criteria = new CDbCriteria();
                $criteria->compare('id', '<>1');
                $criteria->addNotInCondition('role', $author);
                $users = Users::model()->active()->findAll($criteria);
            }

            $list = array();
            foreach($users as $u)
            {
                $list[$u->id] = $u->getFullName();
            }
            return $list;
        }

        public static function getManagers()
        {
            return self::model()->active()->findAll('role = :manager', array('manager' => self::ROLE_MANAGER));
        }

//        Определение кол-во времени пользователя на сайте

        public static function getUserTimeOnSite($id)
        {
            $model = self::model()->findByPk($id);

            $date = date_diff(new DateTime(), new DateTime(date('Y-m-d', $model->create_time)));
            $days = $date->d;
            $mount = $date->m;
            $year = $date->y;

            $result = '';

            if($days <= 30)
            {
                if ($days <= 1)
                    return '1 день';
                if ($days <= 4)
                    return $days . ' дня';
                return $days . ' дней';
            }
            if($mount <= 12)
            {
                if ($mount == 1)
                    $result .= '1 месяц';
                if ($mount <= 4)
                    $result .= $mount . ' месяца';
                $result .= $mount . ' месяцев';
            }
            if($year <= 12)
            {
                if ($year == 1)
                    $result .= '1 год';
                if ($year <= 4)
                    $result .= $year . ' года';
                $result .= $year . ' лет';
            }

            return $result;
        }
    }
