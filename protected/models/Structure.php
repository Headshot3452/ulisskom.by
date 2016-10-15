<?php

/**
 * This is the model class for table "structure".
 *
 * The followings are the available columns in table 'structure':
 * @property string $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $root
 * @property string $language_id
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $title
 * @property string $name
 * @property string $text
 * @property string $layout
 * @property integer $meta_robots_index
 * @property integer $meta_robots_follow
 * @property integer $sitemap
 * @property string $redirect
 * @property integer $ping
 * @property integer $create_time
 * @property integer $update_time
 * @property string $author_id
 * @property integer $system
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property MenuItem[] $menuItems
 * @property Language $language
 * @property Users $author
 * @property StructureModules[] $structureModules
 * @property StructureWidgets[] $structureWidgets
 */
class Structure extends Model
{
    const PATH_LAYOUTS='application.views.frontend.layouts';

    const SYSTEM_PRIVATE=1;
    const META_ROBOTS_INDEX=0;
    const META_ROBOTS_NOINDEX=1;
    const META_ROBOTS_FOLLOW=0;
    const META_ROBOTS_NOFOLLOW=1;
    const SITEMAP_YES=0;
    const SITEMAP_NO=1;
    const PING_YES=0;
    const PING_NO=1;

//    public $icon=array('class'=>'icon-module-small-structure','url'=>'#');
    public $icon=array('class'=>'icon-admin-folder-news','url'=>'#');

    const PathImage='data/structure/';

    public $item_file = '';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Structure the static model class
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
		return 'structure';
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
			array('lft, rgt, level, meta_robots_index, meta_robots_follow, sitemap, ping, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
			array('author_id', 'length', 'max'=>11),
            array('redirect', 'length', 'max'=>125),
			array('seo_title, seo_keywords, title, name', 'length', 'max'=>255),
			array('seo_description, text, text_more, layout', 'safe', 'on'=>'insert,update'),
            array('item_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lft, rgt, level, root, language_id, seo_title, seo_keywords, seo_description, title, name, text, text_more, layout, meta_robots_index, meta_robots_follow, sitemap, redirect, ping, create_time, update_time, author_id, system, status', 'safe', 'on'=>'search'),
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
            'menuItems' => array(self::HAS_MANY, 'MenuItem', 'structure_id'),
            'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
            'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
            'module' => array(self::HAS_ONE, 'StructureModules', 'structure_id'),
            'widgets' => array(self::HAS_MANY, 'StructureWidgets', 'structure_id'),
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
			'language_id' => Yii::t('app','Language'),
			'seo_title' => Yii::t('app','Seo Title'),
			'seo_keywords' => Yii::t('app','Seo Keywords'),
			'seo_description' => Yii::t('app','Seo Description'),
			'title' => Yii::t('app','Title'),
			'name' => Yii::t('app','Url page'),
			'text' => Yii::t('app','Text'),
            'text_more' => Yii::t('app','Text More'),
            'layout' => Yii::t('app','Layout'),
            'meta_robots_index' => Yii::t('app','Meta Robots Index'),
            'meta_robots_follow' => Yii::t('app','Meta Robots Follow'),
            'sitemap' => Yii::t('app','Sitemap'),
            'redirect' => Yii::t('app','Redirect'),
            'ping' => Yii::t('app','Ping'),
			'create_time' => Yii::t('app','Create Time'),
			'update_time' => Yii::t('app','Update Time'),
			'author_id' => Yii::t('app','Author'),
            'system' => Yii::t('app','System'),
			'status' => Yii::t('app','Status'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
        $criteria->compare('root',$this->root);
		$criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);
		$criteria->compare('seo_description',$this->seo_description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
        $criteria->compare('text_more',$this->text_more,true);
        $criteria->compare('layout',$this->layout,true);
        $criteria->compare('meta_robots_index',$this->meta_robots_index);
        $criteria->compare('meta_robots_follow',$this->meta_robots_follow);
        $criteria->compare('sitemap',$this->sitemap);
        $criteria->compare('redirect',$this->redirect,true);
        $criteria->compare('ping',$this->ping);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('author_id',$this->author_id,true);
        $criteria->compare('system',$this->system);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function init()
    {
        $this->meta_robots_index=self::META_ROBOTS_INDEX;
        $this->meta_robots_follow=self::META_ROBOTS_FOLLOW;
        $this->sitemap=self::SITEMAP_YES;
        $this->ping=self::PING_YES;
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->module && $this->module->isNewRecord)
        {
            $this->module->structure_id = $this->id;

            $this->module->save();
        }
//        elseif($this->module && )

        $widgets_for_children=array();
        foreach($this->widgets as $widget)
        {
            // задаём членам id команды
            $widgets_for_children=array();

            $widget->structure_id = $this->id;

            $new=$widget->isNewRecord;
            $save=$widget->save();

            if ($new && $save && $widget->for_children!=false)
            {
                $widgets_for_children[]=clone $widget;
            }
        }

        if (!empty($widgets_for_children))
        {
            $children=$this->children()->findAll();
            foreach($children as $child)
            {
                $child->widgets=array();
                foreach ($widgets_for_children as $item)
                {
                    $child->addRelatedRecord('widgets',clone $item,count($child->widgets));
                }
                $child->saveNode();
            }
        }
    }
	
 	public function scopes()
    {
        $alias=$this->getTableAlias();
        return array('tree'=>array(
                        'order'=>$alias.'.`lft`'
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
                'ContentBehavior'=>array(
                    'class'=>'application.behaviors.ContentBehavior',
                ),
				'LanguageBehavior' => array(
	                'class' => 'application.behaviors.LanguageBehavior',
	            ),
				'NestedSetBehavior'=>array(
	                 'class'=>'application.behaviors.NestedSetBehavior',
                     'hasManyRoots'=>true
	            ),
                'ImageBehavior'=>array(
                    'class'=>'application.behaviors.ImageBehavior',
                    'path'=>self::PathImage,
                    'files_attr_model'=>'images',
                    'sizes'=>array('small'=>array('150','150'), 'big'=>array('800','800')),
                    'quality'=>100
                ),
	        );
    }
	
	public static function getTreeForMenu($language_id)
    {
        return self::model()->language($language_id)->notDeleted()->tree()->findAll(array('select'=>'t.`id`,t.`lft`,t.`rgt`,t.`level`,t.`root`,t.`title`,t.`status`,t.`system`'));
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->module)
        {
            $name=$this->module->module->name;
            $this->icon=array('class'=>'icon-admin-folder-news', 'url'=>CHtml::normalizeUrl(array($name.'/index')));
        }

        if (empty($this->layout))
        {
            $this->layout='frontend';
        }
    }

    public static function getLayouts($key=null)
    {
       $array=array();

       $dir=Yii::getPathOfAlias(self::PATH_LAYOUTS);
       $files=scandir($dir);

       $count=count($files);
       for ($i=2;$i<$count;$i++)
       {
           if ($files[$i]!='clear.php' && substr($files[$i],0,1)!='_')
           {
               $path=pathinfo($files[$i]);
               if ($path['extension']=='php')
               {
                   $array[$path['filename']]=$path['filename'];
               }
           }
       }

      return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public function getBlocksInLayout()
    {
        $array=array();

        $path=Yii::getPathOfAlias(self::PATH_LAYOUTS);
        $layout=$path.'/'.$this->layout.'.php';
        $header=$path.'/_header.php';
        $footer=$path.'/_footer.php';

        $content='';

        if (file_exists($layout))
        {
            if (file_exists($header))
            {
                $content.=file_get_contents($header);
            }
            $content.=file_get_contents($layout);
            if (file_exists($footer))
            {
                $content.=file_get_contents($footer);
            }
            preg_match_all('/\[\[b\:([^\]]+)\]\]/ims',$content,$matches);
            if (!empty($matches))
            {
                foreach($matches[1] as $block)
                {
                    list($name,$args)=explode('|',$block);
                    $array[$name]=$name;
                }
            }
        }
        return $array;
    }

    /**
     * Добавление страниц в структуру из конфига с слоем и виджетами по умолчанию
     * @param array $items
     */
    public function addModulePages($items=array())
    {
        if (!empty($items))
        {
            foreach($items as $key=>$item)
            {
                $temp=array();
                $struct=new Structure();
                foreach($this->widgets as $widget)
                {
                    $temp[]=clone $widget;
                }
                $struct->widgets=$temp;
                $struct->layout=$this->layout;
                $struct->name=$key;
                $struct->title=$item;
                $struct->system=self::SYSTEM_PRIVATE;
                $struct->status=self::STATUS_OK;
                $struct->appendTo($this);
            }
        }
    }

    /**
     * Удаления страниц модуля
     * @param array $items
     */

    public function removeModulePages($items)
    {
        if (is_array($items))
        {
            $pages = array_keys($items);

            $criteria = new CDbCriteria();
            $criteria->addCondition('`lft`>:lft');
            $criteria->addCondition('`rgt`<:rgt');
            $criteria->addCondition('`root`=:root');
            $criteria->addCondition('`level`<=:level');
            $criteria->params=array(
                ':lft'=>$this->lft,
                ':rgt'=>$this->rgt,
                ':root'=>$this->root,
                ':level'=>($this->level+1),
            );
            $criteria->addInCondition('name',$pages);
            $this->deleteAll($criteria);
        }
    }

    public static function findRootForLanguage($language)
    {
        return self::getHome($language);
    }

    public static function getMetaRobotsIndex($key=null)
    {
        $array=array(
            self::META_ROBOTS_INDEX => 'Index',
            self::META_ROBOTS_NOINDEX => 'Noindex',
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public static function getMetaRobotsFollow($key = null)
    {
        $array=array(
            self::META_ROBOTS_FOLLOW => 'Follow',
            self::META_ROBOTS_NOFOLLOW => 'Nofollow',
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public static function getSitemap($key = null)
    {
        $array=array(
            self::SITEMAP_YES => Yii::t('app', 'Yes'),
            self::SITEMAP_NO => Yii::t('app', 'No'),
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public static function getPing($key = null)
    {
        $array = array(
            self::PING_YES => Yii::t('app', 'Yes'),
            self::PING_NO => Yii::t('app', 'No'),
        );

        return $key === null ? $array : self::getArrayItem($array, $key);
    }

    public static function getHome($language_id)
    {
        return self::model()->roots()->language($language_id)->find();
    }

    public static function getCategory($language=1)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'lft ASC';

        return self::model()->language($language)->active()->findAll($criteria);
    }
}