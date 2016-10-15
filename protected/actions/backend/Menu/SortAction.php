<?php

class SortAction extends BackendAction
{
    public function run()
    {
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
        $product_id = htmlspecialchars($_POST['id']);
        $model_name = $this->getModelName();
        $model_m = $model_name::model();
        $model = $model_m->findByPk($product_id);
        $tec_sort = $model->sort;
        $new_sort  = htmlspecialchars($_POST['index']) + 1;
//        echo 'текущее положение:'.$tec_sort;
//        echo 'новое положение:'.$new_sort;
        $criteria=new CDbCriteria;
        if($new_sort > 0) {
            if ($new_sort < $tec_sort) {
                $criteria->condition = ' `menu_id` = :parent_id AND `sort` >= :new_sort AND `sort` < :tec_sort ';
                $incrim = 1;
            } else {
                $criteria->condition = ' `menu_id` = :parent_id AND `sort` <= :new_sort AND `sort` > :tec_sort ';
                $incrim = -1;
            }
            $criteria->params = array('parent_id'=>$model->parent_id ,':new_sort'=> $new_sort, ':tec_sort' => $tec_sort);
            $model_m->updateCounters(array('sort'=>$incrim),$criteria);
            $model->sort = $new_sort;
            $model->save();
//            var_dump($model->errors);
        }
    }
}