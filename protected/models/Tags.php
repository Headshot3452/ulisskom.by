<?php

/**
 * This is the model class for table "tags".
 *
 * The followings are the available columns in table 'tags':
 * @property string $id
 * @property string $language_id
 * @property string $title
 * @property string $name
 *
 * The followings are the available model relations:
 * @property TagItems[] $tagItems
 * @property Language $language
 */
class Tags extends Model
{
    const TYPE_RU = 1;
    const TYPE_EU = 2;
    const TYPE_NUMBER = 3;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tags';
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
			array('language_id', 'length', 'max'=>11),
			array('title, name', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, title, name, type, time, count', 'safe', 'on'=>'search'),
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
			'tagItems' => array(self::HAS_MANY, 'TagItems', 'tag_id'),
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
			'language_id' => 'Language',
			'title' => 'Title',
			'name' => 'Name',
            'count' => 'Count'
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
		$criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
        $criteria->compare('count',$this->count,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tags the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'ContentBehavior'=>array(
                'class'=>'application.behaviors.ContentBehavior',
            ),
            'LanguageBehavior' => array(
                'class' => 'application.behaviors.LanguageBehavior',
            ),
        );
    }

    public static function saveTags($title, $module_id, $parent_id, $item_id, $tags_old)
    {
        $tags = explode(',', $title);
        $tags_old = explode(',', $tags_old);

        $tags = array_unique($tags);

        foreach($tags as $key => $tag)
        {
            if(!in_array($tag, $tags_old))
            {
                $item = self::model()->findByAttributes(array('title' => trim($tag)));

                if (!$item) {
                    $item = new self;
                    $item->title = $tag;
                    $item->time = time();
                    $item->count = 1;

                    if(preg_match('/[a-z]/',$tag)) {
                        $item->type = Tags::TYPE_EU;
                    }
                    else if(preg_match('/[а-яё]/',$tag)){
                        $item->type = Tags::TYPE_RU;
                    }
                    else{
                        $item->type = Tags::TYPE_NUMBER;
                    }

                    $item->save();
                } else {
                    $item->count += 1;
                    $item->save(false);
                }

                $tag_item = new TagItems();
                $tag_item->tag_id = $item->id;
                $tag_item->module_id = $module_id;
                $tag_item->item_id = $item_id;
                $tag_item->parent_id = $parent_id;

                $tag_item->save(false);
            }
        }

        $str_old = implode(',', $tags_old);

        if(!empty($str_old))
        foreach($tags_old as $tag)
        {
            if(!in_array($tag, $tags))
            {
                $item = self::model()->findByAttributes(array('title' => trim($tag)));

                if($item)
                {
                    $tag_item = TagItems::model()->find('tag_id=:tag_id AND item_id=:item_id',
                        array(':tag_id' => $item->id, ':item_id' => $item_id));
                }

                if($tag_item)
                {
                    $item->count -= 1;
                    $item->save(false);

                    $tag_item->delete();
                }
            }
        }
    }

    public static function searchTags($term,$language,$limit=5)
    {
        $criteria=new CDbCriteria;
        $criteria->condition='t.`title` LIKE :title';
        $criteria->params=array(':title'=>$term.'%');
        $criteria->scopes=array(
            'language'=>array($language),
        );

        return self::model()->findAll($criteria);
    }

    public static function getTagsProvider($date_from = '', $date_to = '', $status = 1, $sort = 't.title',$order = 'ASC', $title='')
    {

        $criteria = new CDbCriteria();

        if($status)
        {
            $criteria->addCondition('t.type=:status');
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

        if($title)
        {
            $criteria->addCondition('`t`.`title` LIKE :title');
            $params[':title']=$title.'%';
        }

        if(isset($params))
        {
            $criteria->params=$params;
        }

        $criteria->order = $sort.' '.$order;
        return new CActiveDataProvider(new self, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>50,
                'pageVar'=>'page'
            )
        ));
    }

    public static function getStatusTagsSort($status)
    {
        switch($status){
            case 1:{$status='Последние Русские';};break;
            case 2:{$status='Последние English';};break;
            case 3:{$status='От А до Я';};break;
            case 4:{$status='От A до Z';};break;
        }

        return $status;
    }

    public static function getPopularTags($category_id = 0, $module_id, $limit = 10, $language = 1)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'count DESC';
        $criteria->limit = $limit;

        $criteria->distinct = true;
        $criteria->join = 'LEFT JOIN tag_items as item ON item.tag_id = t.id';
        $criteria->condition = '`item`.`module_id`=:module_id';
        $criteria->params = array(':module_id'=>$module_id);

        if($category_id != 0)
        {
            $model = BlogTree::model()->findByPk($category_id);
            $parent = $model->descendants()->findAll();

            $array = array();
            foreach ($parent as $item)
            {
                $array[] = $item->id;
            }
            $array[] = $category_id;

            $criteria->addCondition('`item`.`parent_id` IN ('.implode(',',$array).')');
        }

        return self::model()->language($language)->findAll($criteria);
    }

    public static function getAllTags($category_id = 0, $module_id, $title='', $language = 1)
    {
        $criteria = new CDbCriteria();

        $criteria->distinct = true;
        $criteria->join = 'LEFT JOIN tag_items as item ON item.tag_id = t.id';
        $criteria->condition = '`item`.`module_id`=:module_id';
        $params[':module_id'] = $module_id;

        if($category_id != 0)
        {
            $model = BlogTree::model()->findByPk($category_id);
            $parent = $model->descendants()->findAll();

            $array = array();
            foreach ($parent as $item)
            {
                $array[] = $item->id;
            }
            $array[] = $category_id;

            $criteria->addCondition('`item`.`parent_id` IN ('.implode(',',$array).')');
        }

        if($title != '#')
        {
            if ($title != '')
            {
                $criteria->addCondition('`t`.`title` LIKE :title');
                $params[':title'] = $title . '%';
            }
        }
        else
        {
            $criteria->addCondition('`t`.`type`=:type');
            $params[':type'] = Tags::TYPE_NUMBER;
        }

        $criteria->params=$params;

        return self::model()->language($language)->findAll($criteria);
    }
}
