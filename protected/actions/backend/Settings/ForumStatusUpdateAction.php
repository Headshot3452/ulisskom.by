<?php

class ForumStatusUpdateAction extends BackendAction
{
    public function run()
    {
        $language = $this->controller->getCurrentLanguage();
        $language_id = $language->id;

        if (isset($_POST['ForumStatus']['remove'])) {
            foreach ($_POST['ForumStatus']['remove'] as $key => $value) {
                $model = new ForumStatus();
                $item = $model::model()->findByPk($key);

                if(isset($item))
                {
                    $item->delete();
                }
            }
        }

        if (isset($_POST['ForumStatus']['text'])) {
            foreach ($_POST['ForumStatus']['text'] as $key => $value) {
                $model = new ForumStatus();
                $item = $model::model()->findByPk($key);

                if (!empty($item->id)) {
                    if (empty($value)) {
                        $item->delete();
                    } else {
                        $item->text = $value;
                        $item->period = $_POST['ForumStatus']['period'][$key];
                        $item->save();
                    }

                } elseif (!empty($value)) {
                    $model->text = $value;
                    $model->period = $_POST['ForumStatus']['period'][$key];
                    $model->language_id = $language_id;
                    $model->save();
                }
            }

            Yii::app()->user->setFlash('modal', 'Параметры сохранены.');
        }

        $this->redirect('/admin/settings/statusForum/');
    }
}