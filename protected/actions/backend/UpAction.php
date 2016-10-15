<?php
class UpAction extends BackendAction
{
    public function run()
    {
        $model = $this->getModel()->moveUp();
        $this->controller->redirect(Yii::app()->request->urlReferrer);
    }
}