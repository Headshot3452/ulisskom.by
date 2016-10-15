<?php

/**
 * This is the model class for table "contacts_phone".
 *
 * The followings are the available columns in table 'contacts_phone':
 * @property string $id
 * @property string $language_id
 * @property string $number
 * @property string $operator
 * @property integer $status
 */
class Comments extends Model
{
    const MODULE_ID = 100;

	const STATUS_NEW = 1;
	const STATUS_MODERETION = 2;
	const STATUS_ARCHIVE = 3;
	const STATUS_PLACEMENT = 4;
    const STATUS_DONT_PLACEMENT = 5;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('text', 'required'),
			array('text, name, email, phone', 'required', 'on'=>'guest'),
			array('user_id, time, post_id, module_id', 'numerical', 'integerOnly'=>true),
            array('email', 'email'),
            array('name', 'unique'),
            array('phone', 'match', 'pattern'=>Yii::app()->params['phone']['regexp']),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language_id, user_id, time, post_id, module_id, text, status', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'language_id' => Yii::t('app','Language'),
			'user_id' => Yii::t('app','User'),
			'time' => Yii::t('app','Time'),
			'post_id' => Yii::t('app','Post'),
			'module_id' => Yii::t('app','Module'),
            'text' => Yii::t('app','TextComment'),
            'status' => Yii::t('app','Status'),
            'name' => Yii::t('app','Nickname'),
            'email' => Yii::t('app','Email'),
            'phone' => Yii::t('app','Phone'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('module_id',$this->module_id);
        $criteria->compare('text',$this->text);
        $criteria->compare('`t`.`status`', Comments::STATUS_PLACEMENT);
        $criteria->compare('name',$this->name);
        $criteria->compare('email',$this->email);
        $criteria->compare('phone',$this->phone);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactsPhone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
    {
	    return array(
				'LanguageBehavior' => array(
	                'class' => 'application.behaviors.LanguageBehavior',
	            ),
	        );
    }

    public static function getCommentsProvider($pagesize = 15, $date_from = '', $date_to = '',
                                               $status = 1, $sort = 't.time',$order = 'ASC',
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

    public function active()
    {
        if ($this->hasAttribute('status'))
        {
            $array=$this->getCriteriaAlias();
            $array['criteria']->mergeWith(array(
                    'condition'=>'`'.$array['alias'].'`.`status`='.self::STATUS_PLACEMENT.' OR `status`='.self::STATUS_DONT_PLACEMENT
                )
            );
        }
        return $this;
    }

    public static function CommentLastForUser($id)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->compare('user_id', $id);

        $model = self::model()->find($criteria);

        return $model;
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

	public static function getPostForComment($id)
	{
		$model = self::model()->findByPk($id);
		$module = $model->module->model;

		return $module::model()->findByPk($model->post_id);
	}

    public static function getCountCommentForPost($post_id, $module_id)
    {
        return self::model()->active()->count('post_id=:post_id AND module_id=:module_id',
            array(':post_id'=>$post_id, ':module_id'=>$module_id));
    }

//    формирование дерева комментариев
    public static function getComments($parent_id=0, $post_id, $module_id)
    {
        $model = self::model()->active()->findAll('parent_id=:parent_id AND post_id=:post_id AND module_id=:module_id',
            array(':parent_id'=>$parent_id, ':post_id'=>$post_id, ':module_id'=>$module_id));

        if($model)
        {
            foreach($model as $key=>$value)
            {
                echo Yii::app()->controller->renderPartial('_comment',
                    array('model'=>$value, 'post_id'=>$post_id, 'module_id'=>$module_id));
            }
        }
        else
        {
            return false;
        }
    }
}
