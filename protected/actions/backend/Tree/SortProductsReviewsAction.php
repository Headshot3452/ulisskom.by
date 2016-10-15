<?php
    /** @var tec_sort -- Текущее положение товара*/
    /** @var new_sort  -- Состояние товара после сортировки пользователем*/

    class SortProductsReviewsAction extends BackendAction
    {
        public function run()
        {
            $product_id = htmlspecialchars($_POST['id']);
            $model_name = $this->getModelName();
            $model_m = $model_name::model();
            $model = $model_m->findByPk($product_id);

            $tec_sort = $model->sort;
            $new_sort  = htmlspecialchars($_POST['index']) + 1;
            echo 'текущее положение:'.$tec_sort;
            echo 'новое положение:'.$new_sort;

            $criteria = new CDbCriteria;
            if($new_sort > 0)
            {
                if ($new_sort < $tec_sort)
                {
                    $criteria->condition = ' `sort` >= :new_sort AND `sort` < :tec_sort ';
                    $incrim = 1;
                }
                else
                {
                    $criteria->condition = ' `sort` <= :new_sort AND `sort` > :tec_sort ';
                    $incrim = -1;
                }
                $criteria->params = array(':new_sort'=> $new_sort, ':tec_sort' => $tec_sort);
                $model_m->updateCounters(array('sort' => $incrim), $criteria);
                $model->sort = $new_sort;
                $model->update();
            }
        }
    }
?>
