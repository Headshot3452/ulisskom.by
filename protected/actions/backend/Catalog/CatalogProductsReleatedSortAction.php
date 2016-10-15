<?php
    class CatalogProductsReleatedSortAction extends BackendAction
    {
        public function run()
        {
            $product_id = htmlspecialchars($_POST['id']);
            $model = ProductsReleated::model()->findByPk($product_id);
            echo '<pre>';
            print_r($model->sort);
            echo '</pre>';
            $tec_sort = $model->sort;
            $new_sort = htmlspecialchars($_POST['index']) + 1;
            echo 'текущее положение:'.$tec_sort;
            echo 'новое положение:'.$new_sort;
            $criteria = new CDbCriteria;
            if ($new_sort > 0)
            {
                if ($new_sort < $tec_sort)
                {
                    $criteria->condition = ' `product_id` = :product_id AND `sort` >= :new_sort AND `sort` < :tec_sort ';
                    $incrim = 1;
                }
                else
                {
                    $criteria->condition = ' `product_id` = :product_id AND `sort` <= :new_sort AND `sort` > :tec_sort ';
                    $incrim = -1;
                }
                $criteria->params = array('product_id' => $model->product_id, ':new_sort' => $new_sort, ':tec_sort' => $tec_sort);
                ProductsReleated::model()->updateCounters(array('sort' => $incrim), $criteria);
                $model->sort = $new_sort;
                $model->save();
            }
        }
    }
