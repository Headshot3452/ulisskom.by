<?php

class CopyMoveAction extends BackendAction
{
    public function run()
    {
        if (!empty($_POST['checkbox'])) {
            $model = $this->getModelName();
            $model = $model::model();

            $products = array_keys($_POST['checkbox']);
            $parent_id = $_POST['parent_category'];
            $criteria = new CDbCriteria();
            $criteria->select = new CDbExpression(' MAX(`sort`) AS `sort` ');
            $criteria->condition = '`parent_id`=:parent_id';
            $criteria->params = array(':parent_id' => $parent_id);
            $max_sort = $model->find($criteria);

            $sort = (!$max_sort->sort) ? 1 : $max_sort->sort + 1;
            unset($max_sort);
            unset($criteria);

            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $products);
            $products_arr = $model->findAll($criteria);
            foreach ($products_arr as $value) {
                if (!empty($_POST['move'])) {
                    $value->parent_id = $parent_id;
                    $value->sort = $sort;
                    $value->detachBehavior('ImageBehavior');
                    if ($value->hasAttribute('time')) {
                        $value->time = strtotime($model->time);
                    }
                    $value->update();
                    $sort++;
                } else {
                    $new_model = $this->getModelName();
                    $new_model = new $new_model;
                    $new_model->detachBehavior('ImageBehavior');
                    $new_model->attributes = $value->attributes;

                    if ($new_model->hasAttribute('time')) {
                        $new_model->time = strtotime($model->time);
                    }
                    $new_model->parent_id = $parent_id;
                    $new_model->sort = $sort;

                    $new_model->save();

                    if ($new_model->hasAttribute('name')) {
                        $new_model->name .= '_' . $new_model->id;
                    }
                    if ($new_model->hasAttribute('images')) {
                        $images = unserialize($value->images);

                        $new_images = array();
                        foreach ($images as $key => $value) {
                            $new_images[] = array('path'=>$value['path'], 'name'=>$new_model->id.'_'.$value['name']);
                            
                            copy(Yii::getPathOfAlias('webroot').'/'.$value['path'].'big/'.$value['name'], 
                                Yii::getPathOfAlias('webroot').'/'.$value['path'].'big/'.$new_model->id.'_'.$value['name']);
                            copy(Yii::getPathOfAlias('webroot').'/'.$value['path'].'origin/'.$value['name'], 
                                Yii::getPathOfAlias('webroot').'/'.$value['path'].'origin/'.$new_model->id.'_'.$value['name']);
                            copy(Yii::getPathOfAlias('webroot').'/'.$value['path'].'small/'.$value['name'], 
                                Yii::getPathOfAlias('webroot').'/'.$value['path'].'small/'.$new_model->id.'_'.$value['name']);
                        }

                        $new_model->images = serialize($new_images);
                    }
                    $new_model->update();
                    $sort++;
                    unset($new_model);
                }
            }
        }
    }


}
