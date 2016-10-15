<?php
    /**
     * This is the model class for table "news".
     *
     * The followings are the available columns in table 'news':
     * @property string $id
     * @property string $language_id
     * @property string $seo_title
     * @property string $seo_keywords
     * @property string $seo_description
     * @property string $title
     * @property string $name
     * @property string $time
     * @property string $preview
     * @property string $text
     * @property string $images
     * @property integer $create_time
     * @property integer $update_time
     * @property string $author_id
     * @property integer $status
     *
     * The followings are the available model relations:
     * @property Language $language
     * @property Users $author
     */

    class News extends Model
    {
        public $f_time = '';

        const PathImage = 'data/news/';

        public $item_file = '';

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return News the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'news';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('title', 'filter', 'filter' => 'trim'),
                array('title', 'required'),
                array('status', 'default', 'value' => self::STATUS_OK, 'on' => 'insert'),
                array('create_time, update_time, status', 'numerical', 'integerOnly' => true),
                array('author_id', 'length', 'max' => 10),
                array('seo_title, seo_keywords, title, name', 'length', 'max'=>255),
                array('seo_description, preview, text, item_file, time, time_end', 'safe', 'on'=>'insert, update'),
                array('seo_title, seo_keywords, seo_description, preview,text, status', 'safe'),
                array('id, language_id, seo_title, seo_keywords, seo_description, title, name, time, time_end, preview, text, images, create_time, update_time, author_id, status', 'safe', 'on'=>'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
                'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
                'parent' => array(self::BELONGS_TO, 'NewsTree', 'parent_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'language_id' => Yii::t('app','Language'),
                'seo_title' => Yii::t('app','Seo Title'),
                'seo_keywords' => Yii::t('app','Seo Keywords'),
                'seo_description' => Yii::t('app','Seo Description'),
                'title' => Yii::t('app','Title news'),
                'name' => Yii::t('app','Name news'),
                'time' => Yii::t('app','Publication date'),
                'time_end' => Yii::t('app','Expiration date'),
                'preview' => Yii::t('app','Anons'),
                'text' => Yii::t('app','Text news'),
                'images' => Yii::t('app','Images'),
                'create_time' => Yii::t('app','Create Time'),
                'update_time' => Yii::t('app','Update Time'),
                'author_id' => Yii::t('app','Author'),
                'status' => Yii::t('app','Status'),
            );
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */

        public function search($page_size, $order = 'parent_id')
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('language_id', $this->language_id, true);
            $criteria->compare('seo_title', $this->seo_title, true);
            $criteria->compare('seo_keywords', $this->seo_keywords, true);
            $criteria->compare('seo_description', $this->seo_description, true);
            $criteria->compare('title', $this->title, true);
            $criteria->compare('name', $this->name, true);
            $criteria->compare('time', $this->time, true);
            $criteria->compare('time_end', $this->time_end, true);
            $criteria->compare('preview', $this->preview, true);
            $criteria->compare('text', $this->text, true);
            $criteria->compare('images', $this->images, true);
            $criteria->compare('create_time', $this->create_time);
            $criteria->compare('update_time', $this->update_time);
            $criteria->compare('author_id', $this->author_id, true);
            $criteria->compare('status', $this->status);

            $criteria->order = $order;

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => $page_size,
                        'pageVar' => 'page',
                    ),
                )
            );
        }

        public function behaviors()
        {
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'create_time',
                    'updateAttribute' => 'update_time',
                ),
                'ContentBehavior' => array(
                    'class' => 'application.behaviors.ContentBehavior',
                ),
                'LanguageBehavior' => array(
                    'class' => 'application.behaviors.LanguageBehavior',
                ),
                'ImageBehavior' => array(
                    'class' => 'application.behaviors.ImageBehavior',
                    'path' => self::PathImage,
                    'files_attr_model' => 'images',
                    'sizes' => array('small' => array('300', '300'), 'origin' => array(null, null), 'big' => array('1000', '1000')),
                    'quality' => 100
                ),
            );
        }

        public function beforeValidate()
        {
            if($this->scenario != 'update_status')
            {
                if (!$this->time)
                {
                    $this->time = time();
                }
                else
                {
                    $this->time = strtotime($this->time);
                }

                if($this->time_end)
                {
                    $this->time_end = strtotime($this->time_end);
                }

            }
            return parent::beforeValidate();
        }

        public function afterFind()
        {
            $this->f_time = date('m/d/Y', $this->time);
        }

        public static function getLastNews($limit, $language,
                                           $select = 't.`id`, t.`title`, t.`name`, t.`time`, t.`preview`, t.`images`')
        {
            $criteria = new CDbCriteria();
            $criteria->select = $select;
            $criteria->order = 't.`time` DESC';
            $criteria->limit = $limit;

            return self::model()->language($language)->active()->findAll($criteria);
        }

        public static function getNewsByName($name,$language)
        {
            return self::model()->language($language)->active()->find('name = :name', array(':name' => $name));
        }

        public function getProviderNews($language, $parent_id)
        {
            $criteria = new CDbCriteria;

            $criteria->compare('parent_id', $parent_id);

            $criteria->scopes = array(
               'language' => array($language),
               'active',
            );

            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        /**
         *  товары во всех дочерних категориях для категории $category_id
         * @param $category_id - ид родительской категори, для которой ищутся товары
         * @param bool $same  - искать в категории $category_id
         * @throws InvalidArgumentException
         */

        public function parent($category_id, $same=true)
        {
            $sign = $same ? '=' : '';

            $category = $this->getInstanceRelation('parent')->findByPk($category_id);
            if(!$category) throw new InvalidArgumentException('Категория с id='.$category_id.' не найдена');

            $this->with('parent');

            $array = $this->getCriteriaAlias();
            $array['criteria']->mergeWith(
                array(
                    'condition'=>'`parent`.`lft`>'.$sign.$category->lft.' AND `parent`.`rgt`<'.$sign.$category->rgt.' AND `parent`.`root`='.$category->root,
                    'order' => '`lft` ASC, `t`.`sort` ASC',
                )
            );

            $array['criteria']->mergeWith(
                array(
                    'condition' => '`parent`.`status` ='.self::STATUS_OK,
                )
            );

            return $this;
        }
    }