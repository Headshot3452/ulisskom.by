<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property string $id
 * @property string $menu_id
 * @property integer $parent_id
 * @property string $structure_id
 * @property string $title
 * @property string $url
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property Menu $menu
 * @property Structure $structure
 */
class MenuItem extends Model
{
    public $icon=array('class'=>'icon-admin-folder-news','url'=>'#');
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title', 'filter', 'filter'=>'trim'),
			array('title', 'required'),
            array('parent_id, sort', 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true),
            array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('structure_id', 'length', 'max'=>10),
            array('url', 'length', 'max'=>255),
			array('title', 'length', 'max'=>128),
            array('id, lft, rgt, level, root, structure_id, parent_id, sort, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'structure' => array(self::BELONGS_TO, 'Structure', 'structure_id')
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
            'root' => 'Root',
            'parent_id' => Yii::t('app','Parent'),
			'structure_id' => Yii::t('app','Structure'),
			'title' => Yii::t('app','Title'),
            'url' => Yii::t('app','Url own'),
            'sort' => Yii::t('app','Sort'),
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('lft',$this->lft);
        $criteria->compare('rgt',$this->rgt);
        $criteria->compare('level',$this->level);
        $criteria->compare('root',$this->root);
        $criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('structure_id',$this->structure_id,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function scopes()
    {
        $alias=$this->getTableAlias();
            return array('tree' => array(
                'order' => $alias.'.`root`,'.$alias.'.`lft`'
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'NestedSetBehavior'=>array(
                     'class'=>'application.behaviors.NestedSetBehavior',
                     'hasManyRoots'=>true
                ),
        );
    }

    public static function getItemsByMenuId($menu_id, $select = 't.*', $select_structure = '*')
    {
        $criteria = new CDbCriteria();
        $criteria->select = $select;
        $criteria->order = 't.`lft`';
        $criteria->with = array('structure' => array('select' => $select_structure));
        $criteria->condition = 't.`root` = :root';
        $criteria->params = array(':root' => $menu_id);

        $criteria->scopes = array(
            'active'
        );

        $model = self::model()->findAll($criteria);

        return $model;
    }

    public function beforeSave()
    {
        if(!parent::beforeSave())
        {
            return false;
        }

        if ($this->parent_id==0)
        {
            $this->parent_id=null;
        }

        if ($this->structure_id==0)
        {
            $this->structure_id=null;
        }

        return true;
    }

    public static function getTreeForMenu($language_id)
    {
        return self::model()->language($language_id)->notDeleted()->tree()->findAll(array('select' => 't.`id`,t.`lft`,t.`rgt`,t.`level`,t.`root`,t.`title`,t.`status`'));
    }
}
