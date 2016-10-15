<?php
class TagsController extends ModuleController
{
    public $layout_in='backend_one_block';

    public function actionBlog()
    {
        $model = new Tags();

        if(isset(Yii::app()->request->isAjaxRequest))
        {
            if(isset($_POST['id']))
            {
                $model::model()->deleteAllByAttributes(array('id'=>$_POST['id']));

                Yii::app()->end();
            }

            if(isset($_POST['title']))
            {
                $model = $model::model()->findByPk($_POST['change_id']);
                $model->title = $_POST['title'];
                $model->save();

                Yii::app()->end();
            }
        }

        $this->pageTitleBlock = $this->renderPartial('_filter', array(), true);

        $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
        $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));
        $title = Yii::app()->request->getParam('search');

        $status = Yii::app()->request->getParam('status');
        $order = 't.id';
        $desc = 'DESC';

        switch($status){
            case 1:{$status=$model::TYPE_RU; $order='t.id';$desc='DESC';};break;
            case 2:{$status=$model::TYPE_EU; $order='t.id';$desc='DESC';};break;
            case 3:{$status=$model::TYPE_RU; $order='t.title';$desc='ASC';};break;
            case 4:{$status=$model::TYPE_EU; $order='t.title';$desc='ASC';};break;
        }

        $dataProvider = Tags::getTagsProvider($date_from, $date_to, $status, $order, $desc, $title);

        $this->render('index',array('model'=>$model,
            'dataProvider' => $dataProvider,
            'status'=>$status,
        ));
    }

    public function getTopMenu()
    {
        return array(
            array('label'=>Yii::t('app','BlogTree'), 'url'=>array('tags/blog')),
        );
    }


    public static function getModuleName()
    {
        return Yii::t('app','Tags');
    }

    public function actionSearch($term)
    {
       $tags=Tags::searchTags($term,$this->getCurrentLanguage()->id);
       $result=CHtml::listData($tags,'id','title');
       echo CJSON::encode($result);
    }

    protected  function strToTime($str)
    {
        if($str)
        {
            $date = explode('.',$str);
            if(count($date) == 3)
            {
                return mktime(0,0,0,$date[1],$date[0],$date[2]);
            }

        }

        return '';
    }

    public static function getActionsConfig()
    {
        return array(
            'blog' => array('label' => 'Тэги','parent'=>'main_settings'),
        );
    }
}