<?php

class FeedbackUpdateAction extends BackendAction
{
    public function run($id)
    {
        $model = $this->getModel();

        $this->controller->layout_in='backend_one_block';

        if(isset($_POST['Feedback']))
        {
            $model->attributes = $_POST['Feedback'];
            if($model->save())
            {
                Yii::app()->user->setFlash('alert-swal',
                    array(
                        'header' => 'Выполнено',
                        'content' => 'Данные успешно сохранены!',
                    )
                );
                $this->redirect($this->controller->createUrl('update').'?id='.$id);
            }
        }

        if(isset($_GET['name'])){
            Yii::app()->request->sendFile($_GET['name'], file_get_contents(Yii::getPathOfAlias('webroot').'/data/feedback/'.$_GET['name']));
        }

        $this->controller->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), '/admin/feedback').'Вопрос № '.$model->id.' <span>'.date("d.m.y", $model->time).' в '.date("h:m", $model->time).'</span>','/admin/feedback');
        $this->controller->pageTitleBlock.=$this->renderPartial('_status', array('model'=>$model), true);

        $this->render(array('model'=>$model));
    }
}