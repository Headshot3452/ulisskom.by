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
class Followers extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'followers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, follower_id, time', 'required'),
			array('user_id, follower_id, time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, follower_id, time', 'safe', 'on'=>'search'),
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
            'follower' => array(self::BELONGS_TO, 'Users', 'follower_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'user_id' => Yii::t('app','User'),
			'time' => Yii::t('app','Time'),
			'follower_id' => Yii::t('app','Follower'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('follower_id',$this->follower_id);

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

    public static function getCountFollowersForUser($user_id)
    {
        return Followers::model()->count('user_id=:user_id AND follower_id=:follower_id',
            array(':user_id'=>$user_id, ':follower_id'=>Yii::app()->user->id));
    }

    public static function getFollowerProvider($user_id, $pagesize=15, $follower=false)
    {
        $criteria = new CDbCriteria();

        if(!$follower)
        {
            $criteria->compare('user_id', $user_id);
        }
        else
        {
            $criteria->compare('follower_id', $user_id);
        }

        $criteria->order = 'id DESC';

        return new CActiveDataProvider(new self, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$pagesize
            )
        ));
    }

    public static function getNewFollower($user_id, $pagesize=15)
    {
        $time = time() - 24*60*60;

        $criteria = new CDbCriteria();
        $criteria->condition = 'time>:time AND user_id=:user_id';
        $criteria->params = array(':time'=>$time, ':user_id'=>$user_id);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider(new self, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$pagesize
            )
        ));
    }

    public static function getNewPostForFollower($user_id, $pagesize=15)
    {
        $time = time() - 24*60*60;

        $users = self::model()->findAll('follower_id=:follower_id',
            array(':follower_id'=>$user_id));

        if($users) {
            $array = array();
            foreach ($users as $user) {
                $array[] = $user->user_id;
            }

            $criteria = new CDbCriteria();
            $criteria->condition = 'time>:time AND user_id IN (' . implode(',', $array) . ') AND status=:status';
            $criteria->params = array(':time' => $time, ':status' => Blog::STATUS_PLACEMENT);
            $criteria->group = 'user_id';
            $criteria->select = 'count(user_id) as view, user_id';
            $criteria->order = 'id DESC';

            $model = new Blog();

            return new CActiveDataProvider($model, array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pagesize
                )
            ));
        }
        else
        {
            return false;
        }
    }
}
