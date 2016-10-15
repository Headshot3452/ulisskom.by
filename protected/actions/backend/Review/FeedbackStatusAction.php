<?php

class FeedbackStatusAction extends BackendAction
{
    public function run()
    {
        if(!empty($_POST['checkbox'])) {
            $products  = array_keys($_POST['checkbox']);
            $model = $this->getModelName();
            $model = $model::model();
            $criteria=new CDbCriteria();
            $criteria->addInCondition('id',$products);
//            var_dump($_POST['status']);

            if($_POST['status'] == ReviewItem::STATUS_DELETED)
            {
                var_dump($_POST['status']);

                $model->deleteAll(array($criteria));
            }
            else
            {
                $model->updateAll(array('status' => $_POST['status']), $criteria);
            }
        }
    }
}
