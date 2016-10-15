<?php
    class NestedMultiRootUpdateAction extends Action
    {
        public function run()
        {
            $model = $this->getModel();
            if(isset($_POST[$this->modelName]))
            {
                $model->attributes = $_POST[$this->modelName];
                if ($model->validate())
                {
                    if ($model->getIsNewRecord())
                    {
                        $id_parent = (isset($_POST['parent_id'])) ? $_POST['parent_id'] : Yii::app()->request->getParam('parent');

                        if ($id_parent !== null)
                        {
                            $parent = $model::model()->findByPk($id_parent);
                            if($parent)
                            {
                                $model->appendTo($parent);
                            }
                            else
                            {
                                throw new CHttpException(404, Yii::t('base', 'The specified record cannot be found.'));
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
                            if ($model->status == model::STATUS_DELETED)
                            {
                                NestedSetHelper::nestedSetChildrenStatus($model);
                            }
                        }

                        if(isset($_POST['parent_id']))
                        {
                            $parent = $model::model()->findByPk($_POST['parent_id']);
                            $model->moveAsFirst($parent);
                        }
                        $model->saveNode(false);
                    }

                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );

                    if ($this->model->getIsNewRecord())
                    {
//                        $this->redirect();
                    }
                    else
                    {
//                        $this->refresh();
                    }
                }
            }
            $this->render(array('model' => $model));
        }
    }