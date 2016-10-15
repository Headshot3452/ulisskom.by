<?php

/**
 * This is the model class for table "ask_answer".
 *
 * The followings are the available columns in table 'ask_answer':
 * @property string $id
 * @property string $language_id
 * @property string $parent_id
 * @property integer $sort
 * @property integer $answer_ok
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $title
 * @property string $name
 * @property string $time
 * @property string $preview
 * @property string $text
 * @property string $images
 * @property string $create_time
 * @property string $update_time
 * @property string $author_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property AskAnswerTree $parent
 * @property Language $language
 * @property Users $author
 */
class AskAnswer extends Model
{
	public $f_time = '';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ask_answer';
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
            array('hits','default','value'=>0,'on'=>'insert'),
			array('time, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
			array('author_id', 'length', 'max'=>10),
			array('seo_title, seo_keywords, title, name', 'length', 'max'=>255),
			array('seo_description, preview, text,item_file', 'safe', 'on'=>'insert,update'),
			array('seo_title, seo_keywords,seo_description, preview,text,status,hits', 'safe'),
			array('id, language_id, seo_title, seo_keywords, seo_description, answer_ok, title, name, time, preview, text, images, create_time, update_time, author_id, status, hits', 'safe', 'on'=>'search'),
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
			'parent' => array(self::BELONGS_TO, 'AskAnswerTree', 'parent_id'),
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
			'language_id' => Yii::t('app','Language'),
			'seo_title' => Yii::t('app','Seo Title'),
			'seo_keywords' => Yii::t('app','Seo Keywords'),
			'seo_description' => Yii::t('app','Seo Description'),
			'answer_ok' => Yii::t('app','Answer Ok'),
			'title' => Yii::t('app','Title ask answer'),
			'name' => Yii::t('app','Name ask answer'),
			'time' => Yii::t('app','Publication date'),
			'preview' => Yii::t('app','Anons'),
			'text' => Yii::t('app','Text ask answer'),
			'images' => Yii::t('app','Images'),
			'create_time' => Yii::t('app','Create Time'),
			'update_time' => Yii::t('app','Update Time'),
			'author_id' => Yii::t('app','Author'),
			'status' => Yii::t('app','Status'),
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
	public function search($count, $name=null, $hits=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('answer_ok',$this->answer_ok);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);
		$criteria->compare('seo_description',$this->seo_description,true);
		$criteria->compare('title',$this->title,true);

        if(!empty($name))
        {
            $criteria->condition='`t`.`title` LIKE :name';
            $criteria->params=array(':name'=>$name.'%');
        }

		$criteria->compare('time',$this->time,true);
		$criteria->compare('preview',$this->preview,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('status',$this->status);

        if($hits)
        {
            if(empty($name)) {
                $criteria->condition = 'hits>0';
            }
            else{
                $criteria->condition = '`t`.`title` LIKE :name AND `t`.`hits`>0';
            }
            $criteria->order = 'hits DESC';
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$count,
                'pageVar'=>'page',
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AskAnswer the static model class
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
		);
	}


	public function beforeValidate()
	{
		if ($this->time=='')
		{
			$this->time=time();
		}
		else
			$this->time=strtotime($this->time);
		return parent::beforeValidate();
	}

	public function afterFind()
	{
		$this->f_time=date('m/d/Y H:m',$this->time);
	}

    public static function getAskAnswerByName($name,$language)
    {
        return self::model()->language($language)->active()->find('name=:name',array(':name'=>$name));
    }

	public function getProviderAskAnswer($language=1)
	{
		$criteria=new CDbCriteria;
		$criteria->scopes=array(
			'language'=>array($language),
			'active',
		);

		return new CActiveDataProvider(new self, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>10,
                'pageVar'=>'page',
            ),
		));
	}

	/**
	 *  ������ �� ���� �������� ���������� ��� ��������� $category_id
	 * @param $category_id - �� ������������ ��������, ��� ������� ������ ������
	 * @param bool $same  - ������ � ��������� $category_id
	 * @throws InvalidArgumentException
	 */
	public function parent($category_id,$same=true)
	{
		$sign = $same? '=' : '';

		$category = $this->getInstanceRelation('parent')->findByPk($category_id);
		if(!$category) throw new InvalidArgumentException('��������� � id='.$category_id.' �� �������');

		$this->with('parent');

		$array=$this->getCriteriaAlias();
		$array['criteria']->mergeWith(array(
				'condition'=>'`parent`.`lft`>'.$sign.$category->lft.' AND `parent`.`rgt`<'.$sign.$category->rgt,
                'order' => '`lft` ASC, `t`.`sort` ASC',
			)
		);

		$array['criteria']->mergeWith(array(
			'condition'=>'`parent`.`status` ='.self::STATUS_OK,
		));

		return $this;
	}
}
