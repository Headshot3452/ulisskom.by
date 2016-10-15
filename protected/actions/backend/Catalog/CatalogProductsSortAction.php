<?php
/** @var int $last_sort -- Текущее положение товара*/
/** @var int $tec_sort  -- Состояние товара после сортировки пользователем*/
class CatalogProductsSortAction extends BackendAction
{
    public function run()
    {
        $product_id = htmlspecialchars($_POST['id']);
        $model = CatalogProducts::model()->findByPk($product_id);
        $tec_sort = $model->sort;
        $new_sort  = htmlspecialchars($_POST['index']);
//        echo 'текущее положение:'.$tec_sort;
//        echo 'новое положение:'.$new_sort;
        $criteria=new CDbCriteria;
        if($new_sort > 0) {
            if ($new_sort < $tec_sort) {
                $criteria->condition = ' `parent_id` = :parent_id AND `sort` >= :new_sort AND `sort` < :tec_sort ';
                $incrim = 1;
            } else {
                $criteria->condition = ' `parent_id` = :parent_id AND `sort` <= :new_sort AND `sort` > :tec_sort ';
                $incrim = -1;
            }
            $criteria->params = array('parent_id'=>$model->parent_id ,':new_sort'=> $new_sort, ':tec_sort' => $tec_sort);
            CatalogProducts::model()->updateCounters(array('sort'=>$incrim),$criteria);
            $model->sort = $new_sort;
            $model->save();
        }
    }
}
?>
