<?php

/**
 * This is the model class for table "gallery_images".
 *
 * The followings are the available columns in table 'gallery_images':
 * @property string $id
 * @property string $gallery_id
 * @property string $title
 * @property string $description
 * @property string $images
 * @property string $parent_id
 * @property string $language_id
 * @property string $sort
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Gallery $gallery
 */
class GalleryImages extends Model
{
    const PathImage='data/gallery/images/';

    public $item_file='';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gallery_images';
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
			array('parent_id', 'required'),
            array('status','default','value'=>self::STATUS_OK,'on'=>'insert'),
            array('parent_id, update_time, status', 'numerical', 'integerOnly'=>true),
            array('language_id', 'length', 'max'=>10),
            array('seo_title, seo_keywords, title', 'length', 'max'=>255),
            array('item_file, seo_description, description, author_id, title','safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, parent_id, language_id, seo_title, seo_keywords, seo_description, images, title, name, text, create_time, update_time, status', 'safe', 'on'=>'search'),
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
            'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
			'parent' => array(self::BELONGS_TO, 'GalleryTree', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'author_id' => Yii::t('app','Author'),
			'title' => Yii::t('app','Title'),
			'description' => Yii::t('app','Description'),
			'images' => Yii::t('app','Photo'),
            'create_time' => Yii::t('app','Create Time'),
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
	public function search($page_size)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
        $criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);
		$criteria->compare('seo_description',$this->seo_description,true);
        $criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'pageVar'=>'page',
				),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryImages1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
            'ImageBehavior'=>array(
                'class'=>'application.behaviors.ImageBehavior',
                'path'=>self::PathImage,
                'find_path'=>'getDir',
                'files_attr_model'=>'images',
                'sizes'=>array(
                    'big'=>array(
                        isset($this->parent->big_width) ?$this->parent->big_width: 160,
                        isset($this->parent->big_width) ?$this->parent->big_width: 160),
                    'small'=>array(
                        isset($this->parent->small_width) ?$this->parent->small_width: 160,
                        isset($this->parent->small_width) ?$this->parent->small_width: 160
                    )),
                'quality'=>100
            ),
        );
    }

    public function getDir()
    {
        if ($this->isNewRecord)
        {
            $id=self::model()->dbConnection->createCommand('SELECT MAX(`id`) as max_id FROM '.$this->tableName())->queryRow();
            $id=$id['max_id']+1;
        }
        else
        {
            $id=$this->id;
        }

        $dir=self::PathImage.$id.'/';
        if (!file_exists($dir))
        {
            mkdir($dir);
        }

        return $dir;
    }

    public static function getItemsByGalleryId($gallery_id)
    {
        return self::model()->findAllByAttributes(array('parent_id'=>$gallery_id));
    }

	public function parent($category_id,$same=true)
	{
		$sign = $same? '=' : '';

		$category = $this->getInstanceRelation('parent')->findByPk($category_id);
		if(!$category) throw new InvalidArgumentException('Категория с id='.$category_id.' не найдена');

		$this->with('parent');

		$array=$this->getCriteriaAlias();
		$array['criteria']->mergeWith(array(
						'condition'=>'`parent`.`lft`>'.$sign.$category->lft.' AND `parent`.`rgt`<'.$sign.$category->rgt.' AND `parent`.`root`='.$category->root,
						'order' => '`t`.`parent_id` DESC, `t`.`sort` ASC',//'`t`.`parent_id` DESC, `t`.`sort` DESC',
				)
		);

		$array['criteria']->mergeWith(array(
				'condition'=>'`parent`.`status` ='.self::STATUS_OK,
		));

		return $this;
	}

	public function getAll($same=true)
	{

		$this->with('parent');

		$array=$this->getCriteriaAlias();
		$array['criteria']->mergeWith(array(
						'order' => '`t`.`parent_id` ASC, `t`.`sort` ASC',
				)
		);

		$array['criteria']->mergeWith(array(
				'condition'=>'`parent`.`status` ='.self::STATUS_OK,
		));

		return $this;
	}
}
