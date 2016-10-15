<?php
class ArticlesController extends BackendController
{
    public function beforeRender($view)
    {
        if (!parent::beforeRender($view))
        {
            return false;
        }

        $this->addButton('left_create',array(
            'url'=>$this->createUrl('create'),
            'label'=>Yii::t('app','Create article'),
        ));

        return true;
    }
}
?>