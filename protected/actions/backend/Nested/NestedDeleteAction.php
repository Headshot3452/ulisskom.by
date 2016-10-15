<?php
class NestedDeleteAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();
        if ($model->hasAttribute('status'))
        {
            $model->status=Model::STATUS_DELETED;
            $model->saveNode(false);
            NestedSetHelper::nestedSetChildrenStatus($model);
        }
        else
        {
            $model->deleteNode();
        }
        Yii::app()->user->setFlash('success', Yii::t('app','Deleted'));
        $this->redirect();
    }
}
?>
