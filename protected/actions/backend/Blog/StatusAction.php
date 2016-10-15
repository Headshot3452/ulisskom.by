<?php

class StatusAction extends BackendAction
{
    public function run()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model_name = $_POST['model'];
            $model = $model_name::model();

            if (!empty($_POST['checkbox'])) {
                $products = $_POST['checkbox'];

                $model = $model::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $products);

                $model->updateAll(array('status' => $_POST['status']), $criteria);
            }
            Yii::app()->end();
        }
    }
}