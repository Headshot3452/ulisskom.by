<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property string $id
 * @property string $language_id
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $title
 * @property string $name
 * @property string $preview
 * @property string $text
 * @property string $images
 * @property string $create_time
 * @property string $update_time
 * @property string $author_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property Users $author
 */
class Articles extends Model
{
	const PathImage='data/articles/';

	public $item_file='';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'articles';
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
			array('language_id, create_time, update_time, author_id', 'length', 'max'=>11),
			array('seo_title, seo_keywords, title, name', 'length', 'max'=>255),
			array('seo_description, preview, text,item_file', 'safe', 'on'=>'insert,update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, seo_title, seo_keywords, seo_description, title, name, preview, text, images, create_time, update_time, author_id, status', 'safe', 'on'=>'search'),
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
			'seo_title' => 'Seo Title',
			'seo_keywords' => 'Seo Keywords',
			'seo_description' => 'Seo Description',
			'title' => 'Title',
			'name' => 'Name',
			'preview' => 'Preview',
			'text' => 'Text',
			'images' => 'Images',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
			'status' => 'Status',
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
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);
		$criteria->compare('seo_description',$this->seo_description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('preview',$this->preview,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Articles the static model class
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
			'ContentBehavior'=>array(
				'class'=>'application.behaviors.ContentBehavior',
			),
			'LanguageBehavior' => array(
				'class' => 'application.behaviors.LanguageBehavior',
			),
			'ImageBehavior'=>array(
				'class'=>'application.behaviors.ImageBehavior',
				'path'=>self::PathImage,
				'files_attr_model'=>'images',
				'sizes'=>array('small'=>array('300','300'),'big'=>array('1000','1000')),
				'quality'=>100
			),
		);
	}

	public static function getLastArticles($limit,$language,$select='t.`id`,t.`title`,t.`name`,t.`preview`')
	{
		$criteria=new CDbCriteria();
		$criteria->select=$select;
		$criteria->order='t.`create_time` DESC';
		$criteria->limit=$limit;

		return self::model()->language($language)->active()->findAll($criteria);
	}

	public static function getArticleByName($name,$language)
	{
		return self::model()->language($language)->active()->find('name=:name',array(':name'=>$name));
	}

	public function getProviderArticles($language)
	{
		$criteria=new CDbCriteria;
		$criteria->scopes=array(
			'language'=>array($language),
			'active',
		);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
