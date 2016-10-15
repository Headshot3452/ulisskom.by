<?php

class BlogUpdateAction extends BackendAction
{
    public function run($id)
    {
        $model = $this->getModel();

        $this->controller->layout_in='backend_one_block';

        if(isset($_POST['Blog']))
        {
            $model->scenario = 'update';

            $model->attributes = $_POST['Blog'];
            if($model->save())
            {
                if(UserSettings::getUserSetting($model->user_id)->send_block == 1 && $model->status == Blog::STATUS_DONT_PLACEMENT)
                {
                    $bodyEmail = $this->controller->renderEmail('block', array('model' => $model, 'type'=>'пост'));
                    $mail = Yii::app()->mailer->isHtml(true)->setFrom(Settings::getSettings(Yii::app()->params['settings_id'])->email);
                    $mail->send($model->user->email, 'Subject', $bodyEmail);
                }

                Yii::app()->user->setFlash('alert-swal',
                    array(
                        'header' => 'Выполнено',
                        'content' => 'Данные успешно сохранены!',
                    )
                );
                $this->redirect($this->controller->createUrl('update').'?id='.$id);
            }
        }

        if(Yii::app()->controller->id == 'blog')
        {
            $this->controller->pageTitleBlock = BackendHelper::htmlTitleBlockDefault(
                CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), '/admin/blog') .
                'Пост # ' . $model->id . ' <span>' . date("d.m.Y", $model->time) . ' в ' . date("h:m", $model->time) .
                '</span>', '/admin/blog');
        }
        else
        {
            $this->controller->pageTitleBlock = BackendHelper::htmlTitleBlockDefault(
                CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), '/admin/blogclients') .
                'Пост # ' . $model->id . ' <span>' . date("d.m.Y", $model->time) . ' в ' . date("h:m", $model->time) .
                '</span>', '/admin/blogclients');
        }
        $this->controller->pageTitleBlock.='<button class="btn btn-default btn-change"><span class="glyphicon glyphicon-pencil"></span></button>';
        $this->controller->pageTitleBlock.=$this->renderPartial('_status_update', array('model'=>$model), true);

        $this->render(array('model'=>$model));
    }
}