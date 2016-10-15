<?php
    /** @var tec_sort -- Текущее положение товара*/
    /** @var new_sort  -- Состояние товара после сортировки пользователем*/

    class SortAction extends BackendAction
    {
        public function run()
        {
            $product_id = htmlspecialchars($_POST['id']);
            $model_name = $this->getModelName();

            $model_m = $model_name::model();
            $model = $model_m->findByPk($product_id);
            var_dump($model);
            $tec_sort = $model->sort;
            $new_sort  = htmlspecialchars($_POST['index']);
            echo 'текущее положение:'.$tec_sort;
            echo 'новое положение:'.$new_sort;
            $criteria=new CDbCriteria;
            if($new_sort > 0)
            {
                if(isset($model->parent_id))
                {
                    if ($new_sort < $tec_sort)
                    {
                        $criteria->condition = ' `parent_id` = :parent_id AND `sort` >= :new_sort AND `sort` < :tec_sort ';
                        $incrim = 1;
                    }
                    else
                    {
                        $criteria->condition = ' `parent_id` = :parent_id AND `sort` <= :new_sort AND `sort` > :tec_sort ';
                        $incrim = -1;
                    }
                    $criteria->params = array('parent_id'=>$model->parent_id ,':new_sort'=> $new_sort, ':tec_sort' => $tec_sort);
                    $model_m->updateCounters(array('sort'=>$incrim),$criteria);
                    $model->sort = $new_sort;

//                    if($model->hasAttribute('time'))
//                    {
//                        $model->time = strtotime($model->time);
//                    }

                    $model->detachBehavior('ImageBehavior');

                }
                else
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
                    $model_m->updateCounters(array('sort'=>$incrim), $criteria);
                    $model->sort = $new_sort;
                }

                $model->update();
            }
        }
    }
?>
