<?php

class SettingMapsUpdateAction extends BackendAction
{
    public function run($id)
    {
        $language = $this->controller->getCurrentLanguage();
        $language_id = $language->id;
        $maps_id = $id;

        if(isset($_POST['MapsPlacemarkGroup']['remove']))
        {
            foreach ($_POST['MapsPlacemarkGroup']['remove'] as $key => $value)
            {
                $model = new MapsPlacemarkGroup();
                $item = $model->findByPk($key);

                $criteria=new CDbCriteria;
                $criteria->condition = ' `maps_id` = :maps_id AND `sort` > :sort ';
                $criteria->params = array(':sort'=>$item->sort, ':maps_id'=>$id);

                $model::model()->updateCounters(array('sort'=>-1),$criteria);

                $item->deleteByPk($key);
            }
        }

        if(isset($_POST['MapsPlacemarkGroup']['title']))
        {
            $model = new MapsPlacemarkGroup();
            $criteria = new CDbCriteria();
            $criteria->compare('maps_id', $maps_id);
            $criteria->select = 'MAX(`sort`) as `sort`';
            $sort = $model->find($criteria);
            $sort = $sort->sort + 1;

            foreach ($_POST['MapsPlacemarkGroup']['title'] as $key => $value)
            {
                $model = new MapsPlacemarkGroup();
                $item = $model->findByPk($key);

                if(!empty($item->id))
                {
                    if(empty($value))
                    {
                        $item->delete();
                    }
                    else
                    {
                        $item->title = $_POST['MapsPlacemarkGroup']['title'][$key];
                        $item->save();
                    }

                }
                elseif(!empty($value))
                {
                    $model->title = $_POST['MapsPlacemarkGroup']['title'][$key];
                    $model->sort = $sort;
                    $model->maps_id = $id;
                    $model->status = 1;
                    $model->language_id = $language_id;
                    $model->save();
                    $sort++;
                }
            }
        }

        Yii::app()->user->setFlash('modal', Yii::t('app','Product has been saved'));

        $this->redirect($this->controller->createUrl('update', array('id'=>$id)));
    }

}