<?php

class FeedbackDeleteAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();
        $model->deleteNode();
        Yii::app()->user->setFlash('success', Yii::t('app','Deleted'));
        $this->redirect($this->controller->createUrl('settings'));
    }
}