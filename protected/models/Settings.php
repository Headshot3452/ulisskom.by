<?php
    /**
     * This is the model class for table "settings".
     *
     * The followings are the available columns in table 'settings':
     * @property string $id
     * @property string $otdel
     * @property string $mts
     * @property string $velcom
     * @property string $fax
     * @property string $street
     * @property string $skype
     * @property string $vk
     * @property string $email
     */

    class Settings extends Model
    {
        const PathFavicon = 'images/';
        public $images = 'Favicon.exe';
        public $item_file = '';

        public function tableName()
        {
            return 'settings';
        }

        public function rules()
        {
            return array(
                array('site_name, company, email', 'required'),
                array('vk, company, facebook, odnoklasniki, google, twitter', 'length', 'max' => 100),
                array('email_order, email_comment, email_callback, site_name', 'length', 'max' => 50),
                array('item_file, images, info', 'safe'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array();
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id'                => 'ID',
                'site_name'         => Yii::t('app','Site Name'),
                'company'           => Yii::t('app','Company'),
                'email_order'       => Yii::t('app','Email order'),
                'email_comment'     => Yii::t('app','Email comment'),
                'email_callback'    => Yii::t('app','Email callback'),
                'vk'                => 'Vk:',
                'facebook'          => 'Facebook:',
                'twitter'           => 'Twitter:',
                'odnoklasniki'      => Yii::t('app','Odnoklasniki'),
                'google'            => 'Google+:',
                'info'              => Yii::t('app','Info about company'),
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

            $criteria->compare('id', $this->id, true);
            $criteria->compare('vk', $this->vk, true);
            $criteria->compare('facebook', $this->facebook, true);
            $criteria->compare('company', $this->company, true);
            $criteria->compare('odnoklasniki', $this->odnoklasniki, true);
            $criteria->compare('google', $this->google, true);
            $criteria->compare('twitter', $this->twitter, true);
            $criteria->compare('email_order', $this->email_order, true);
            $criteria->compare('email_comment', $this->email_comment, true);
            $criteria->compare('email_callback', $this->email_callback, true);

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        public function behaviors()
        {
            return array(
                'ImageBehavior' => array(
                    'class' => 'application.behaviors.ImageBehavior',
                    'path' => self::PathFavicon,
                    'files_attr_model' => 'images',
                    'sizes' => array('small' => array('32','32'), 'original' => array(null, null)),
                    'quality' => 100
                ),
            );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return Settings the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public static function getSettings($id)
        {
            return self::model()->findByPk($id);
        }
    }
