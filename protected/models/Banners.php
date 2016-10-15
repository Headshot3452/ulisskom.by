<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property string $id
 * @property string $language_id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $image
 * @property integer $status
 */
class Banners extends Model
{
    public $item_file;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Banners the static model class
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
        return 'banners';
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
            array('title, item_file', 'required'),
            array('status','default','value'=>self::STATUS_OK,'on'=>'insert'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('url', 'length', 'max'=>255),
            array('title', 'length', 'max'=>128),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, language_id, title, url, image, description, status', 'safe', 'on'=>'search'),
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
            'language_id' => Yii::t('app','Language'),
            'title' => Yii::t('app','Title'),
            'description' => Yii::t('app','Description'),
            'url' => Yii::t('app','Url'),
            'image' => Yii::t('app','Image'),
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
        $criteria->compare('language_id',$this->language_id);
        $criteria->compare('title',$this->title);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('image',$this->image,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class'=>'application.behaviors.ImageBehavior',
                'path'=>'data/banners/',
                'sizes'=>array('big'=>array('1920','1080'),'small'=>array('245','180')),
                'files_attr_model'=>'image'
            ),
            'LanguageBehavior' => array(
                'class' => 'application.behaviors.LanguageBehavior',
            ),
        );
    }

    public static function getBanner($id)
    {
        return self::model()->findByPk($id);
    }
}