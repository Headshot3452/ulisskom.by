<?php

class FeedbackRootUpdateAction extends Action
{
    public function run()
    {
        $model = $this->getModel();

        $this->controller->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), 
            '/admin/feedback').$this->controller->getModuleName(),'/admin/feedback');

        if(isset($_GET['parent'])){
            $this->controller->_active_category_id=$_GET['parent'];
        }

        if(isset($_POST[$this->modelName]))
        {
            $model->attributes = $_POST[$this->modelName];
            if ($model->validate())
            {
                if ($model->getIsNewRecord())
                {
                    $id_parent = Yii::app()->request->getParam('parent');
                    if ($id_parent!==null)
                    {
                        $parent=$model::model()->findByPk($id_parent);
                        if($parent)
                        {
                            $model->appendTo($parent);
                        }
                        else
                        {
                            throw new CHttpException(404,Yii::t('base','The specified record cannot be found.'));
                        }
                    }
                    else
                    {
                        $model->saveNode();
                    }
                }
                else
                {
                    if ($model->hasAttribute('status'))
                    {
                        if ($model->status==model::STATUS_DELETED)
                        {
                            NestedSetHelper::nestedSetChildrenStatus($model);
                        }
                    }
                    $model->saveNode(false);
                }
                if ($this->model->getIsNewRecord())
                {
                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );
                    $this->redirect($this->controller->createUrl('settings').'?category_id='.$model->id);
                }
                else
                {
                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );
                    $this->redirect($this->controller->createUrl('settings').'?category_id='.$model->id);
                }
            }
        }

        $this->render(array('model' => $model));
    }
}