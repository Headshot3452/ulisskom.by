<?php
    class StatusAction extends BackendAction
    {
        public function run()
        {
            if(!empty($_POST['checkbox']))
            {
                $products  = array_keys($_POST['checkbox']);
                $model = $this->getModelName();
                $model = $model::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $products);
                $model->updateAll(array('status' => $_POST['status']), $criteria);

                Yii::app()->user->setFlash('alert-swal',
                    array(
                        'header' => 'Выполнено',
                        'content' => 'Данные успешно сохранены!',
                    )
                );
            }
        }
    }