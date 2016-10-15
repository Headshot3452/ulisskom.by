<?php
class NestedActiveAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();

        if ($model->hasAttribute('status'))
        {
            if ($model->status==$model::STATUS_OK)
            {
                $model->status=$model::STATUS_NOT_ACTIVE;
            }
            else
            {
                $model->status=$model::STATUS_OK;
            }
            $model->saveNode(false,'status');
        }

        if(Yii::app()->request->urlReferrer)
        {
            Yii::app()->request->redirect(Yii::app()->request->urlReferrer);
        }
       $this->redirect();
    }
}
?>
