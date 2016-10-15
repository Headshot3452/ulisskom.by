<?php
    class CatalogParamsSortValueAction extends BackendAction
    {
        public function run()
        {
            $params_val_id = htmlspecialchars($_POST['id']);
            $model = CatalogParamsVal::model()->findByPk($params_val_id);
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
                    $criteria->condition = ' `params_id` = :params_id AND `sort` >= :new_sort AND `sort` < :tec_sort ';
                    $incrim = 1;
                }
                else
                {
                    $criteria->condition = ' `params_id` = :params_id AND `sort` <= :new_sort AND `sort` > :tec_sort ';
                    $incrim = -1;
                }
                $criteria->params = array(':params_id' => $model->params_id, ':new_sort' => $new_sort, ':tec_sort' => $tec_sort);
                CatalogParamsVal::model()->updateCounters(array('sort' => $incrim), $criteria);
                $model->sort = $new_sort;
                $model->save();
            }
        }
    }