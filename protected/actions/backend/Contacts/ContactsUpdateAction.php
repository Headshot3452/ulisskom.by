<?php

class ContactsUpdateAction extends BackendAction
{
    public function run()
    {
        $language = $this->controller->getCurrentLanguage();
        $language_id = $language->id;
        $model = new ContactsPhone();
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(`sort`) as `sort`';
        $sort = $model->find($criteria);
        $sort = $sort->sort + 1;

        $model->deleteAll();

        if(isset($_POST['ContactsPhone']['number']))
        {
            foreach ($_POST['ContactsPhone']['number'] as $key => $value)
            {
                $model = new ContactsPhone();

                if(!empty($value))
                {
                    $model->number = $value;
                    $model->operator = $_POST['ContactsPhone']['operator'][$key];
                    $model->sort = $sort;
                    $model->status = 1;
                    $model->language_id = $language_id;
                    $model->save();
                    $sort++;
                }
            }
        }

        $model = new ContactsAddress();

        $model->deleteAll();

        if(isset($_POST['ContactsAddress']['text']))
        {
            foreach ($_POST['ContactsAddress']['text'] as $key => $value)
            {
                $model = new ContactsAddress();
                
                if(!empty($value))
                {
                    $model->text = $value;
                    $model->map_id = $_POST['ContactsAddress']['map_id'][$key];
                    $model->status = 1;
                    $model->language_id = $language_id;
                    $model->save();
                    $sort++;
                }
            }
        }

        if(isset($_POST['contact_show_feedback']))
        {
            $module_setting = new Settings();
            $module = $module_setting::model()->find();

            $module->contact_show_feedback = $_POST['contact_show_feedback'];
            $module->save(false);
        }

        Yii::app()->user->setFlash('alert-swal',
            array(
                'header' => 'Выполнено',
                'content' => 'Данные успешно сохранены!',
            )
        );

        $this->redirect('index');
    }

}