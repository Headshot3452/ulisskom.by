<?php
    /**
     * This is the model class for table "review_themes_tree".
     *
     * The followings are the available columns in table 'review_themes_tree':
     * @property string $id
     * @property integer $lft
     * @property integer $rgt
     * @property integer $level
     * @property string $language_id
     * @property string $title
     * @property string $name
     * @property integer $status
     * @property string $root
     */

    class ReviewThemesTree extends Model
    {
        public $max_level = 2;

        public $catalog_icon = array('class' => 'fa fa-file-text-o fa-2x', 'url' => '#');

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'review_themes_tree';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('title', 'filter', 'filter' => 'trim'),
                array('title', 'required'),
                array('level', 'numerical', 'integerOnly' => true, 'min'=>0, 'max'=>$this->max_level, 'tooBig'=>Yii::t('app', 'The maximum level is reached')),
                array('lft, rgt, level, status', 'numerical', 'integerOnly' => true),
                array('language_id, root', 'length', 'max' => 11),
                array('title, name', 'length', 'max' => 255),
                array('status', 'default', 'value' => self::STATUS_OK, 'on' => 'insert'),
                array('id, lft, rgt, level, language_id, title, name, status, root', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
                'ReviewItem' => array(self::HAS_MANY, 'ReviewItem', 'parent_id'),
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
                'language_id' => 'Language',
                'title' => Yii::t('app','Title'),
                'name' => Yii::t('app','Name'),
                'status' => Yii::t('app','Status'),
                'root' => 'Root',
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
            $criteria->compare('lft', $this->lft);
            $criteria->compare('rgt', $this->rgt);
            $criteria->compare('level', $this->level);
            $criteria->compare('language_id', $this->language_id, true);
            $criteria->compare('title', $this->title, true);
            $criteria->compare('name', $this->name, true);
            $criteria->compare('status', $this->status);
            $criteria->compare('root', $this->root, true);

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return ReviewThemesTree the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        public function scopes()
        {
            $alias = $this->getTableAlias();
            return array('tree' => array(
                    'order' => $alias . '.`root`,' . $alias . '.`lft`'
                ),
            );
        }

        public function behaviors()
        {
            return array(
                'LanguageBehavior' => array(
                    'class' => 'application.behaviors.LanguageBehavior',
                ),
                'ContentBehavior' => array(
                    'class' => 'application.behaviors.ContentBehavior',
                ),
                'NestedSetBehavior' => array(
                    'class' => 'application.behaviors.ENestedSetBehavior',
                    'hasManyRoots' => true
                ),
            );
        }

        public static function getAllTree($language_id = 1)
        {
            return self::model()->language($language_id)->notDeleted()->tree()->findAll();
        }

        public static function getTreeById($id = null, $language_id = 1)
        {
            return self::model()->language($language_id)->notDeleted()->tree()->findByPk($id);
        }

        public static function getAllTreeFilter($root_id = 1, $language_id = 1)
        {
            $tree = self::model()->language($language_id)->active()->tree()->findAll(
                array(
                    'select' => '`id`, `title`',
                    'condition' => 'level=:level',
                    'params' => array(':level' => self::model()->max_level),
                )
            );

            $array = array();

            foreach ($tree as $key => $value)
            {
                $array[$value->id] = $value->title;
            }

            return $array;
        }

        public function getParents($activeOnly = true)
        {
            if ($activeOnly)
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
