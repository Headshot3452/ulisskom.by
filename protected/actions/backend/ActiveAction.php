<?php
class ActiveAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();
        $model->setScenario($this->scenario);
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
            $model->save(true,'status');
        }

        if(Yii::app()->request->urlReferrer)
        {
            Yii::app()->request->redirect(Yii::app()->request->urlReferrer);
        }
       $this->redirect();
    }
}
?>
