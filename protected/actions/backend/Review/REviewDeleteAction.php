<?php

class ReviewDeleteAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();
        $model->deleteNode();
        $model->saveNode(false);
        Yii::app()->user->setFlash('modal', Yii::t('app','Deleted'));
        $this->redirect($this->controller->createUrl('settings'));
    }
}