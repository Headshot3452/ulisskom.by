<?php

/**
 * This is the model class for table "feedback".
 *
 * The followings are the available columns in table 'feedback':
 * @property string $id
 * @property string $language_id
 * @property integer $sort
 * @property integer $time
 * @property integer $tree_id
 * @property string $primech
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property FeedbackAnswers[] $feedbackAnswers
 */
class Blog extends Model
{
	const STATUS_NEW = 1;
	const STATUS_MODERETION = 2;
	const STATUS_ARCHIVE = 3;
	const STATUS_PLACEMENT = 4;
    const STATUS_DONT_PLACEMENT = 5;

    const STATUS_DRAFT = 6;

    const PathImage='data/blog/';

    public $item_file='';

    public $tags;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, text, title, tags', 'required', 'on'=>'create'),
            array('text, title', 'required', 'on'=>'update'),
            array('parent_id, text, title', 'required', 'on'=>'draft'),
			array('time, parent_id, status', 'numerical', 'integerOnly'=>true),
			array('language_id', 'length', 'max'=>11),
            array('name, title', 'length', 'max'=>255),
			array('title, text, cause', 'safe'),
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, time, parent_id, title, status, text, cause, user_id, name, rating, images, view', 'safe', 'on'=>'search'),
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
			'tree' => array(self::BELONGS_TO, 'BlogTree', 'parent_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'language_id' => Yii::t('app', 'Language'),
			'time' => Yii::t('app', 'Time'),
			'parent_id' => Yii::t('app', 'Parent'),
			'title' => Yii::t('app', 'Title'),
			'status' => Yii::t('app', 'Status'),
            'cause' => Yii::t('app', 'Cause'),
            'user_id' => Yii::t('app', 'Users'),
            'text' => Yii::t('app', 'Text'),
            'tags' => Yii::t('app', 'Tags')
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
	public function search($count, $order='', $post_id = array(), $well=false)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('language_id', $this->language_id, true);
        $criteria->compare('time', $this->time);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('rating', $this->rating);

        if($order!='')
        {
            $criteria->order = 'id DESC';
        }

        if ($well)
        {
            $criteria->order = '`t`.`rating` DESC';
        }

        if($post_id)
        {
            $criteria->condition = '`t`.`id` IN ('.implode(',', $post_id).')';
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$count,
                'pageVar'=>'page',
            )
		));
	}

    public function active()
    {
        if ($this->hasAttribute('status'))
        {
            $array=$this->getCriteriaAlias();
            $array['criteria']->mergeWith(array(
                    'condition'=>'`'.$array['alias'].'`.`status`='.self::STATUS_PLACEMENT
                )
            );
        }
        return $this;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'ImageBehavior'=>array(
                'class'=>'application.behaviors.ImageBehavior',
                'path'=>self::PathImage,
                'files_attr_model'=>'images',
                'sizes'=>array('small'=>array('250','250'),'big'=>array('1000','1000')),
                'quality'=>100
            ),
            'ContentBehavior'=>array(
                'class'=>'application.behaviors.ContentBehavior',
            ),
        );
    }

	public static function getBlogProvider($pagesize = 15, $date_from = '', $date_to = '',
                                           $status = 1, $sort = 't.sort',$order = 'ASC',
                                           $parent_id='', $title='', $user_id=0, $item_id=array())
	{

		$criteria = new CDbCriteria();

		if($status)
		{
			$criteria->addCondition('t.status=:status');
			$params= array(':status'=>$status);
		}

		if($date_from)
		{
			$criteria->addCondition('t.time>:date_from');
			$params[':date_from']=$date_from;
		}

		if($date_to)
		{
			$criteria->addCondition('t.time<:date_to');
			$params[':date_to']=$date_to;
		}

		if($status!=self::STATUS_ARCHIVE)
		{
			$criteria->addCondition('t.status!=3');
		}
		else
		{
			$criteria->addCondition('t.status=3');
		}

		if($parent_id)
		{
			$criteria->addCondition('t.parent_id=:parent_id');
			$params[':parent_id']=$parent_id;
		}

        if($user_id)
        {
            $criteria->addCondition('t.user_id=:user_id');
            $params[':user_id']=$user_id;
        }

        if($title)
        {
            $criteria->addCondition('`t`.`title` LIKE :title');
            $params[':title']=$title.'%';
        }

        if($item_id)
        {
            $criteria->addCondition('`t`.`id` IN ('.implode(',', $item_id).')');
        }

        if($status!=self::STATUS_DRAFT)
        {
            $criteria->addCondition('t.status!=6');
        }

		if(isset($params))
		{
			$criteria->params=$params;
		}

		$criteria->order = $sort.' '.$order;
		return new CActiveDataProvider(new self, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pagesize
			)
		));
	}

    public static function getPostForComment($post_id)
    {
        return self::model()->findByPk($post_id);
    }

    public static function BlogLastForUser($id)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->compare('user_id', $id);

        $model = self::model()->find($criteria);

        return $model;
    }

    public static function getBlogByName($name,$language=1)
    {
        return self::model()->language($language)->find('name=:name',array(':name'=>$name));
    }

    public static function getStatusForSearch($id)
    {
        switch ($id)
        {
            case self::STATUS_NEW: return '<span style="color: blue">Новые</span>';
                break;
            case self::STATUS_MODERETION: return '<span style="color: orange">На модерации</span>';
                break;
            case self::STATUS_PLACEMENT: return '<span style="color: green">Размещенные</span>';
                break;
            case self::STATUS_DONT_PLACEMENT: return '<span style="color: red">Отклонненые</span>';
                break;
            default : return 'Все';
        }
    }

	public static function getStatus($id)
	{
		switch ($id)
		{
			case self::STATUS_NEW: return 'Новый';
				break;
			case self::STATUS_MODERETION: return 'На модерации';
				break;
			case self::STATUS_ARCHIVE: return 'В архив';
				break;
			case self::STATUS_PLACEMENT: return 'Разместить';
				break;
            case self::STATUS_DONT_PLACEMENT: return 'Отклонить';
                break;
			default : return false;
		}
	}

	public static function getColorStatus($status)
	{
		switch ($status)
		{
			case self::STATUS_NEW: return 'blue';
				break;
			case self::STATUS_MODERETION: return 'orange';
				break;
			case self::STATUS_ARCHIVE: return 'gray';
				break;
			case self::STATUS_PLACEMENT: return 'green';
				break;
            case self::STATUS_DONT_PLACEMENT: return 'red';
                break;
			default : return false;
		}
	}

    public function parent($category_id,$same=true)
    {
        $sign = $same? '=' : '';

        $category = $this->getInstanceRelation('tree')->findByPk($category_id);
        if(!$category) throw new InvalidArgumentException('��������� � id='.$category_id.' �� �������');

        $this->with('tree');

        $array=$this->getCriteriaAlias();
        $array['criteria']->mergeWith(array(
                'condition'=>'`tree`.`lft`>'.$sign.$category->lft.' AND `tree`.`rgt`<'.$sign.$category->rgt.' AND `tree`.`root`='.$category->root,
                'order' => '`t`.`id` DESC',
            )
        );

        $array['criteria']->mergeWith(array(
            'condition'=>'`tree`.`status` ='.self::STATUS_OK,
        ));

        return $this;
    }
}
