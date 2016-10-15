<?php
    class NestedUpdateAction extends BackendAction
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
                        if (($id_parent = Yii::app()->request->getParam('parent')) === null)
                        {
                            $criteria = new CDbCriteria();

                            if ($model->hasAttribute('language_id'))
                            {
                                $criteria->condition = 'language_id = :language_id';
                                $criteria->params[':language_id'] = $this->controller->getCurrentLanguage()->id;
                            }

                            if($root = $model::model()->roots()->find($criteria))
                            {
                                if ($root->hasAttribute('status') && $root->status != $root::STATUS_OK)
                                {
                                    $root->status = $root::STATUS_OK;
                                    $root->saveNode(false);
                                }
                                $id_parent = $root->id;
                            }
                            else
                            {
                                $root_model = $this->getModel();
                                $root_model->title = 'Root';
                                if ($root_model->hasAttribute('status'))
                                {
                                    $root_model->status = $root_model::STATUS_OK;
                                }
                                $root_model->saveNode(false);
                                $id_parent = $root_model->id;
                            }
                        }

                        if (isset($id_parent))
                        {
                                $parent = $model::model()->findByPk($id_parent);
                                if(isset($parent))
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
                            throw new CHttpException(404, Yii::t('base', 'The specified record cannot be found.'));
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
                        $model->saveNode(false);
                    }
                    if ($this->model->getIsNewRecord())
                    {
                        $this->redirect();
                    }
                    else
                    {
                        Yii::app()->user->setFlash('alert-swal',
                            array(
                                'header' => 'Выполнено',
                                'content' => 'Данные успешно сохранены!',
                            )
                        );
                       $this->refresh();
                    }
                }
             }
            $this->render(array('model' => $model));
         }
    }