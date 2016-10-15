<?php
class CatalogProductCopyAction extends BackendAction
{
    public function run()
    {
        if(!empty($_POST['checkbox'])) {
            $products  = array_keys($_POST['checkbox']);
            $parent_id = $_POST['parent_category'];
            $criteria  = new CDbCriteria();
            $criteria->select = new CDbExpression(' MAX(`sort`) AS `sort` ');
            $criteria->condition = '`parent_id`=:parent_id';
            $criteria->params = array(':parent_id'=>$parent_id);
            $max_sort = CatalogProducts::model()->find($criteria);

            $sort = (!$max_sort->sort) ? 1 : $max_sort->sort + 1;
            unset($max_sort);
            unset($criteria);

            $model = CatalogProducts::model();

            $criteria=new CDbCriteria();
            $criteria->addInCondition('id',$products);
            $products_arr = $model->findAll($criteria);
//                ++$sort - что-то не то
//                $model->updateAll(array('parent_id'=>$parent_id, 'sort'=>++$sort),$criteria);
            foreach ($products_arr as $value)
            {
                if(!empty($_POST['move'])){
                    $value->parent_id = $parent_id;
                    $value->sort = $sort;
                    $value->save();
                    $sort++;
                }else{
                    $new_model = new CatalogProducts();
                    $new_model->attributes = $value->attributes;
                    // Извращение с тайтлом товара(дабы избежать повторения)
                    $new_model->title .= '_'.md5(rand(0,10000));
                    $new_model->parent_id = $parent_id;
                    $new_model->sort = $sort;
                    $new_model->save();
                    $sort++;
                    unset($new_model);
                }
            }
        }
    }


}
