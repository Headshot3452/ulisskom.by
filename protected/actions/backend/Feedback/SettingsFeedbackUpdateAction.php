<?php

class SettingsFeedbackUpdateAction extends BackendAction
{
    public function run()
    {
        $language = $this->controller->getCurrentLanguage();
        $language_id = $language->id;
        if(isset($_POST['SettingsFeedback']['tree_id']))
            $tree_id = $_POST['SettingsFeedback']['tree_id'];

        if(isset($_POST['SettingsFeedback']['remove']))
        {
            foreach ($_POST['SettingsFeedback']['remove'] as $key => $value)
            {
                $model = new SettingsFeedback();
                $item = $model->findByPk($key);

                $criteria=new CDbCriteria;
                $criteria->condition = ' `tree_id` = :tree_id AND `sort` > :sort ';
                $criteria->params = array(':sort'=>$item->sort, ':tree_id'=>$tree_id);

                $model::model()->updateCounters(array('sort'=>-1),$criteria);

                $item->deleteByPk($key);
            }
        }

        if(isset($_POST['SettingsFeedback']['name']))
        {
            $model = new SettingsFeedback();
            $criteria = new CDbCriteria();
            $criteria->compare('tree_id', $tree_id);
            $criteria->select = 'MAX(`sort`) as `sort`';
            $sort = $model->find($criteria);
            $sort = $sort->sort + 1;

            foreach ($_POST['SettingsFeedback']['name'] as $key => $value)
            {
                $model = new SettingsFeedback();
                $item = $model->findByPk($key);

                if(!empty($item->id))
                {
                    if(empty($value))
                    {
                        $item->delete();
                    }
                    else
                    {
                        $item->name = $value;
                        $item->type = $_POST['SettingsFeedback']['type'][$key];
                        $item->save();
                    }

                }
                elseif(!empty($value))
                {
                    $model->name = $value;
                    $model->type = $_POST['SettingsFeedback']['type'][$key];
                    $model->sort = $sort;
                    $model->tree_id = $tree_id;
                    $model->system = 0;
                    $model->status = 1;
                    $model->language_id = $language_id;
                    $model->save();
                    $sort++;
                }
            }
        }

        if(isset($_POST['load_file']) && isset($_POST['thema_question']))
        {
            $module_setting = new Settings();
            $module = $module_setting::model()->find();

            $module->load_file_feedback = $_POST['load_file'];
            $module->thema_question_feedback = $_POST['thema_question'];
            $module->save(false);
        }

        Yii::app()->user->setFlash('alert-swal',
            array(
                'header' => 'Выполнено',
                'content' => 'Данные успешно сохранены!',
            )
        );

        $this->redirect($this->controller->createUrl('settings'));

        $this->render(array('model'=>$model));
    }

}