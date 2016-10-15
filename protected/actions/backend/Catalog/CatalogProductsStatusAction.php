<?php
class CatalogProductsStatusAction extends BackendAction
{
    public function run()
    {
        if(!empty($_POST['checkbox'])) {
            $products  = array_keys($_POST['checkbox']);
            $model = CatalogProducts::model();
            $criteria=new CDbCriteria();
            $criteria->addInCondition('id',$products);

            $model->updateAll(array('status' => $_POST['status']), $criteria);
        }
    }


}
