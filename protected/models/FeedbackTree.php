<?php

/**
 * This is the model class for table "feedback_tree".
 *
 * The followings are the available columns in table 'feedback_tree':
 * @property string $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $language_id
 * @property string $icon
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
 * @property Language $language
 */
class FeedbackTree extends Model
{
	public $catalog_icon=array('class'=>'icon-admin-folder-news','url'=>'#');
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'feedback_tree';
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
			array('status','default','value'=>self::STATUS_OK,'on'=>'insert'),
			array('lft, rgt, level, create_time, update_time, status, root', 'numerical', 'integerOnly'=>true),
			array('language_id', 'length', 'max'=>11),
			array('seo_title, seo_keywords, title, name', 'length', 'max'=>255),
			array('seo_description,item_file, text','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lft, rgt, level, language_id, icon, images, seo_title, seo_keywords, seo_description, title, name, text, create_time, update_time, status, root', 'safe', 'on'=>'search'),
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
			'language_id' => 'Language',
			'icon' => 'Icon',
			'seo_title' => Yii::t('app','Seo Title'),
			'seo_keywords' => Yii::t('app','Seo Keywords'),
			'seo_description' => Yii::t('app','Seo Description'),
			'title' => Yii::t('app', 'Title'),
			'name' => Yii::t('app','Url page'),
			'text' => Yii::t('app','Text'),
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'status' => 'Status',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);
		$criteria->compare('seo_description',$this->seo_description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('root',$this->root,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FeedbackTree the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes()
	{
		$alias=$this->getTableAlias();
		return array('tree'=>array(
			'order'=>$alias.'.`root`,'.$alias.'.`lft`'
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
		);
	}

	public static function getAllTree($language_id=1)
	{
		return self::model()->language($language_id)->notDeleted()->tree()->findAll();
	}


	/**
	 * ¬озвращает родительские разделы
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

	public static function getAllTreeFilter($language_id=1)
	{
		$tree = self::model()->language($language_id)->notDeleted()->tree()->findAll(array('select'=>'`id`, `title`'));
		$array = array();
		foreach ($tree as $key => $value)
		{
			$array[$value->id]= $value->title;
		}
//		echo '<pre>';
//		print_r($tree);
//		echo '</pre>';
		return $array;
	}

	protected function beforeDelete()
	{
		/*—делано дл€ реального удалени€ параметров, а не смены статусов*/
		return true;
	}
}
