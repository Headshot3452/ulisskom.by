<?php

class SettingsBlogUpdateAction extends BackendAction
{
    public function run()
    {
        if(isset($_POST['setting']))
        {
            foreach ($_POST['setting'] as $key => $value)
            {
                $model = new BlogSetting();

                $model = $model::model()->findByPk($key);
                $model->status = $value;
                $model->save();
            }
        }

        Yii::app()->user->setFlash('alert-swal',
            array(
                'header' => 'Выполнено',
                'content' => 'Данные успешно сохранены!',
            )
        );

        $this->redirect($this->controller->createUrl('settings'));
    }

}