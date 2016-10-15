<?php
    class DeleteAction extends BackendAction
    {
        public function run()
        {
            $model = $this->getModel();
            $model->setScenario($this->scenario);

            if($model->status != 3)
            {
                $model->delete();
                Yii::app()->user->setFlash('success', Yii::t('app','Deleted'));
            }
            if(Yii::app()->request->urlReferrer)
            {
                Yii::app()->request->redirect(Yii::app()->request->urlReferrer);
            }
            $this->redirect();
        }
    }
