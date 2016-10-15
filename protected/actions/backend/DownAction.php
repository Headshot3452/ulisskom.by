<?php
class DownAction extends BackendAction
{
    public function run()
    {
        $model = $this->getModel()->moveDown();
        $this->controller->redirect(Yii::app()->request->urlReferrer);
    }
}