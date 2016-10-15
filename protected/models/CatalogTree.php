<?php
    /**
     * This is the model class for table "catalog_tree".
     *
     * The followings are the available columns in table 'catalog_tree':
     * @property string $id
     * @property integer $lft
     * @property integer $rgt
     * @property integer $level
     * @property string $language_id
     * @property string $icon
     * @property string $images
     * @property string $seo_title
     * @property string $seo_keywords
     * @property string $seo_description
     * @property string $title
     * @property string $name
     * @property string $text
     * @property string $create_time
     * @property string $update_time
     * @property integer $status
     * @property string $root
     *
     * The followings are the available model relations:
     * @property CatalogParams[] $catalogParams
     * @property CatalogProducts[] $catalogProducts
     * @property Language $language
     */

    class CatalogTree extends Model
    {
        const PathImage = 'data/catalog/tree/';

        public $item_file = '';

        public $catalog_icon = array('class' => 'icon-admin-folder-orange', 'url' => '#');

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'catalog_tree';
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
                array('type', 'default', 'value' => '1', 'on' => 'insert'),
                array('lft, rgt, level, create_time, update_time, status, root', 'numerical', 'integerOnly' => true),
                array('language_id', 'length', 'max' => 11),
                array('seo_title, seo_keywords, title, name', 'length', 'max' => 255),
                array('seo_description, item_file, text, type', 'safe'),
                array('id, lft, rgt, level, language_id, icon, images, seo_title, seo_keywords, seo_description, title, name, text, create_time, update_time, status, root', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'catalogParams' => array(self::HAS_MANY, 'CatalogParams', 'catalog_tree_id'),
                'catalogProducts' => array(self::HAS_MANY, 'CatalogProducts', 'parent_id'),
                'item' => array(self::HAS_MANY, 'CatalogProducts', 'parent_id'),
                'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'lft' => 'Lft',
                'rgt' => 'Rgt',
                'level' => 'Level',
                'icon' => 'Icon',
                'images' => 'Images',
                'language_id' => Yii::t('app', 'Language'),
                'seo_title' => Yii::t('app', 'Seo Title'),
                'seo_keywords' => Yii::t('app', 'Seo Keywords'),
                'seo_description' => Yii::t('app', 'Seo Description'),
                'title' => Yii::t('app', 'Title category'),
                'name' => Yii::t('app', 'Name category'),
                'text' => Yii::t('app', 'Text'),
                'create_time' => Yii::t('app', 'Create Time'),
                'update_time' => Yii::t('app', 'Update Time'),
                'status' => Yii::t('app', 'Status'),
                'root' => Yii::t('app', 'Root'),
                'type' => Yii::t('app', 'Type')
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

            $criteria->compare('id', $this->id);
            $criteria->compare('lft', $this->lft);
            $criteria->compare('rgt', $this->rgt);
            $criteria->compare('level', $this->level);
            $criteria->compare('language_id', $this->language_id, true);
            $criteria->compare('icon', $this->icon, true);
            $criteria->compare('images', $this->images, true);
            $criteria->compare('seo_title', $this->seo_title, true);
            $criteria->compare('seo_keywords', $this->seo_keywords, true);
            $criteria->compare('seo_description', $this->seo_description, true);
            $criteria->compare('title', $this->title, true);
            $criteria->compare('name', $this->name, true);
            $criteria->compare('text', $this->text, true);
            $criteria->compare('create_time', $this->create_time);
            $criteria->compare('update_time', $this->update_time);
            $criteria->compare('status', $this->status);
            $criteria->compare('root', $this->root);

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
         * @return CatalogTree the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function scopes()
        {
            $alias = $this->getTableAlias();
            return array(
                'tree' => array(
                    'order' => $alias.'.`root`,'.$alias.'.`lft`'
                ),
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
                'LanguageBehavior' => array(
                    'class' => 'application.behaviors.LanguageBehavior',
                ),
                'ContentBehavior'=>array(
                    'class'=>'application.behaviors.ContentBehavior',
                ),
                'NestedSetBehavior'=>array(
                    'class'=>'application.behaviors.ENestedSetBehavior',
                    'event'=>array(
                        'onBeforeMove'=>array('CatalogEvents','BeforeMoveCatalogTree'),
                        'onAfterMove'=>array('CatalogEvents','AfterMoveCatalogTree'),
                    ),
                    'hasManyRoots'=>true
                ),
                'ImageBehavior'=>array(
                    'class'=>'application.behaviors.ImageBehavior',
                    'path'=>self::PathImage,
                    'files_attr_model'=>'images',
                    'sizes' => array('small' => array('250', '250'), 'original' => array(null, null), 'big' => array('800', '800')),
                    'quality' => 100
                ),
            );
        }

        public static function getAllTree($language_id = 1)
        {
            return self::model()->language($language_id)->notDeleted()->tree()->findAll();
        }

        /**
         * Возвращает родительские разделы
         * @param bool $activeOnly - true только активные, false - неактивные тоже, кроме удаленных
         * @return mixed
         */

        public function getParents($activeOnly = true)
        {
            if($activeOnly)
            {
                $condition = '`status` = 1';
            }
            else
            {
                $condition = '`status` < 3';
            }
            return $this->parent()->findAll($condition);
        }
    }
