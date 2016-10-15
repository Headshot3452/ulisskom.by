<?php

class FeedbackStatusAction extends BackendAction
{
    public function run()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            if(!empty($_POST['checkbox'])) {
                $products  = array_keys($_POST['checkbox']);
                $model = $this->getModelName();
                $model = $model::model();
                $criteria=new CDbCriteria();
                $criteria->addInCondition('id',$products);

                $model->updateAll(array('status' => $_POST['status']), $criteria);
            }
        }
    }
}
