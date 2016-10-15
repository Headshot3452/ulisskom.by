<?php
    /**
     * This is the model class for table "catalog_params".
     *
     * The followings are the available columns in table 'catalog_params':
     * @property integer $id
     * @property integer $catalog_tree_id
     * @property integer $parent_id
     * @property string $title
     * @property integer $type
     *
     * The followings are the available model relations:
     * @property CatalogTree $catalogTree
     * @property CatalogParams $parent
     * @property CatalogParams[] $catalogParams
     * @property CatalogParamsVal[] $catalogParamsVals
     * @property CatalogProductsParams[] $catalogProductsParams
     */

    class CatalogParams extends Model
    {
        const TYPE_TEXT = 1;
        const TYPE_YES_NO = 2;
        const TYPE_SELECT = 3;
        const TYPE_CHECKBOX = 4;

        protected $_values;

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'catalog_params';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('title', 'filter', 'filter' => 'trim'),
                array('status', 'default', 'value' => self::STATUS_OK, 'on' => 'insert_child, insert_parent'),
                array('catalog_tree_id, title, type, unit', 'required'),
                array('catalog_tree_id, parent_id, type', 'numerical', 'integerOnly' => true),
                array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('title', 'length', 'max' => 255),
                array('id, catalog_tree_id, parent_id, title, type', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'catalogTree' => array(self::BELONGS_TO, 'CatalogTree', 'catalog_tree_id'),
                'parent' => array(self::BELONGS_TO, 'CatalogParams', 'parent_id'),
                'catalogParams' => array(self::HAS_MANY, 'CatalogParams', 'parent_id'),
                'catalogParamsVals' => array(self::HAS_MANY, 'CatalogParamsVal', 'params_id', 'order' => 'catalogParamsVals.sort ASC'),
                'catalogProductsParams' => array(self::HAS_MANY, 'CatalogProductsParams', 'params_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'catalog_tree_id' => Yii::t('app', 'Catalog Tree'),
                'parent_id' => Yii::t('app', 'Parent'),
                'title' => Yii::t('app', 'Title'),
                'type' => Yii::t('app', 'Type'),
                'unit' => Yii::t('app', 'Unit'),
                'status' => '',
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

            $criteria->compare('id',$this->id);
            $criteria->compare('catalog_tree_id',$this->catalog_tree_id);
            $criteria->compare('parent_id',$this->parent_id);
            $criteria->compare('title',$this->title,true);
            $criteria->compare('type',$this->type);

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
         * @return CatalogParams the static model class
         */

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public static function getTreeParams($tree_ids)
        {
            return self::model()->with(array('catalogParams', 'catalogParamsVals'))->notDeleted()->findAllByAttributes(array('catalog_tree_id' => $tree_ids), array('order' => 't.parent_id, t.`sort`'));
        }

        public static function getTreeParamsIds($tree_ids)
        {
            return self::model()->with(array('catalogParams','catalogParamsVals'))->findAllByAttributes(array('catalog_tree_id'=>$tree_ids, 'parent_id' => NULL),array('order'=>'t.`catalog_tree_id`'));
        }

        public function getSubForm($key, $form, $tree_id = null, $child_html = ' ')
        {
            $parent = ($this->catalog_tree_id == $tree_id) ? false : true;
            ob_start();
                echo
                    '<div class="parent">
                        <div class="item">
                            '.$form->textField($this, '['.$key.']title', array("class" => "params_title", 'readonly' => $parent)).'
                            '.$form->error($this,'title').'
                            '.$form->hiddenField($this,'['.$key.']type',array('value' => 0));

                            if (!$parent)
                            {
                                echo
                                    '<a href="javascript:void(0)" class="add-sub-form-child">'.Yii::t('app', 'Add parameter').'</a>
                                    <a href="javascript:void(0)" class="del-form"><span class="icon-admin-delete"></span></a>';
                            }
                echo
                            '<div class="child">'.$child_html.'</div>
                        </div>
                    </div>';

            $form = ob_get_contents();

            ob_end_clean();
            return $form;
        }

        public function getSubFormChild($key, $form, $tree_id = null, $readonly = false)
        {
            $parent = ($this->catalog_tree_id == $tree_id) ? false : true;
            ob_start();
                echo
                    '
                        <div class="item" id="'.$key.'">
                        '.$form->textField($this, '['.$key.']title', array("class" => "params_title", 'readonly' => $parent)).'
                        '.$form->error($this, 'title').'
                        '.$form->hiddenField($this, '['.$key.']parent_id').'
                        '.$form->dropDownList($this, '['.$key.']type', self::getType(), array('readonly' => $parent)).'
                        '.$form->error($this, 'type').'
                        '.$form->dropDownList($this, '['.$key.']unit', self::getUnitType(), array('readonly' => $parent)).'
                        '.$form->error($this, 'unit').'
                        '.$form->checkBox($this, '['.$key.']status', array('readonly' => $parent)).'
                        '.$form->label($this, '['.$key.']status');

                            if ($this->catalog_tree_id == $tree_id)
                            {
                                echo
                                    '<img class="sort pull-right" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
                                    <a href="javascript:void(0)" class="del-form">
                                        <span class="icon-admin-delete"></span>
                                    </a>
                                    <div class="values" '.(($this->type<self::TYPE_SELECT) ? 'style="display:none;"' : '' ).'>';
                                echo
                                    '<a href="javascript:void(0)" class="add-value">'.Yii::t('app','Value param').'</a>
                                    <div class="value">';
                                        $values = $this->getValues();

                                foreach ($values as $value)
                                {
                                    $this->getValueForm($value, $form, $parent);
                                }
                                echo
                                    '</div>
                                </div>';
                            }
                    echo
                        '</div>
                    ';

            $form = ob_get_contents();

            ob_end_clean();
            return $form;
        }

        public static function getFilteredTreeParams($tree_ids)
        {
            return self::model()->with(array('catalogParams', 'catalogParamsVals'))->findAllByAttributes(array('catalog_tree_id' => $tree_ids, 'status' => 1), array('order' => 't.`sort`'));
        }

        public function getValueForm($value, $form, $parent = null)
        {
            echo '<div class="item" id="'.$value->id.'">';
            echo $form->textField($value, '['.$this->id.'][values]['.$value->id.']value', array('readonly' => $parent)).
            ' <img class="sort pull-right" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>'.
                ' <a href="javascript:void(0)" class="del-value"><span class="icon-admin-delete"></span></a>'.

                $form->error($value,'value');
            echo '</div>';
        }

        public function getType($key = null)
        {
            $array = array(
                self::TYPE_TEXT => 'text',
                self::TYPE_YES_NO => 'yes / no',
                self::TYPE_SELECT => 'select',
                self::TYPE_CHECKBOX => 'checkbox',
            );
            return ($key === null) ? $array : $this->getArrayItem($array, $key);
        }

        /**
         * Значения параметра
         * @return CatalogParamsVal[]
         */

        public function getValues()
        {
            if ($this->_values === null)
            {
                $this->_values = $this->catalogParamsVals;
            }
            return $this->_values;
        }

        public function setValues($value)
        {
            $this->_values = $value;
        }
    }