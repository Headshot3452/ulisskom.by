<?php
/**
 * This is the model class for table "text_blocks".
 *
 * The followings are the available columns in table 'text_blocks':
 * @property string $id
 * @property string $language_id
 * @property string $title
 * @property string $text
 */
class TextBlocks extends Model
{
    public $max_id;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'text_blocks';
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
            array('text', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, text', 'safe', 'on'=>'search'),
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
            'text' => Yii::t('app','Text'),
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
        $criteria->compare('text',$this->text,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TextBlocks the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function primaryKey()
    {
        return 'id';
    }

    public function behaviors()
    {
        return array(
            'LanguageBehavior' => array(
                'class' => 'application.behaviors.LanguageBehavior',
            ),
        );
    }

    public function beforeSave()
    {
        if (!parent::beforeSave())
        {
            return false;
        }
        if ($this->isNewRecord)
        {
            $criteria=new CDbCriteria();
            $criteria->select='MAX(id) as max_id';
            $criteria->condition='language_id=:language_id';
            $criteria->params=array(':language_id'=>$this->language_id);
            $temp=$this::model()->find($criteria);
            $this->id=$temp->max_id+1;
        }
        return true;
    }

    public static function findById($id, $language_id)
    {
        return self::model()->language($language_id)->findByAttributes(array('id'=>$id));
    }
}