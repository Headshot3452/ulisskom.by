<?php
    class NestedUpdateAction extends BackendAction
    {
        public function run($id = 0)
        {
            $model = $this->getModel();

            if($id)
            {
                $this->controller->_active_category_id = $id;
            }

            $setBreadcrumb=true;

            if ($model->getIsNewRecord())
            {
                $parent=$model->findByPk(Yii::app()->request->getParam("parent"));
                if ($parent == null)
                {
                    $setBreadcrumb = false;
                    $parent = $model::findRootForLanguage($this->controller->getCurrentLanguage()->id);
                }
                $title = Yii::t('app','Create page (module)');
            }
            else
            {
                $title = Yii::t('app','Editing pages').' '.$model->title;
            }

            if ($setBreadcrumb)
            {
                $this->controller->setLastBreadcrumb($title);
            }

            $this->controller->setPageTitle($title);


            $params=array();

            if (!$model->isRoot() && !$model->isNewRecord)
            {
                $id=$model->id;

                if ($model->system!=$model::SYSTEM_PRIVATE)
                {
                    $params=array('id'=>$id);

                    $this->controller->addButtonsLeftMenu('active', array(
                            'url'=>$this->controller->createUrl('active',$params),
                            'active'=>($model->status==$model::STATUS_OK) ? true : false)
                    );
                    $this->controller->addButtonsLeftMenu('delete',array(
                            'url'=>$this->controller->createUrl('delete',$params)
                        )
                    );
                }

                $params=array('parent'=>$id);
            }
            $this->controller->addButtonsLeftMenu('create', array(
                    'url'=>$this->controller->createUrl('create',$params)
                )
            );

            if(isset($_POST[$this->modelName]))
            {
                $insert_widgets=array();
                $update_widgets=array();
                $widgets=$model->widgets;
                if($widgets)
                {
                    $widgets = array_combine(CHtml::listData($widgets,'id','id'), $widgets);
                }

                /*widgets srart*/

                if (!empty($_POST['StructureWidgets']))
                {
                    $post_widgets=$_POST['StructureWidgets'];
                }
                else
                {
                    $post_widgets=array();
                }
                foreach ($post_widgets as $key => $post)
                {
                    if(is_numeric($key))
                    {
                        if(isset($widgets[$key]) && ($widgets[$key]->settings!=$post['settings'] ||
                                ($widgets[$key]->widget_id!=$post['widget_id']  || (isset($post['block']) && $widgets[$key]->block != $post['block']) ||
                                    $widgets[$key]->tree_id!=$post['tree_id'] || $widgets[$key]->view!=$post['view'])))
                        {
                            $widgets[$key]->settings = $post['settings'];
                            $widgets[$key]->widget_id = $post['widget_id'];
                            $widgets[$key]->block = $post['block'];
                            $widgets[$key]->tree_id = $post['tree_id'];
                            $widgets[$key]->view = $post['view'];

                            $update_widgets[]=$widgets[$key];
                        }
                        unset($widgets[$key]);
                    }
                    else
                    {
                        $widget= new StructureWidgets('insert');
                        $widget->attributes=$post;
                        $insert_widgets[]=$widget;
                    }
                }

                $model->widgets=array_merge($insert_widgets,$update_widgets);

                $model->attributes = $_POST[$this->modelName];
                if ($model->validate())
                {
                    //delete old widgets
                    foreach ($widgets as $del)
                    {
                        $del->delete();
                    }

                    /*module srart*/

                    if (isset($_POST[$this->modelName]['module']['module_id']))
                    {
                        $module_id=$_POST[$this->modelName]['module']['module_id'];
                        $module_tree_id= isset($_POST[$this->modelName]['module']['tree_id']) ? $_POST[$this->modelName]['module']['tree_id'] : 0;

                        if(!isset($module_tree_id) || $module_tree_id == '')
                        {
                            $module_tree_id = 0;
                        }

                        if (isset($model->module) && $model->module->module_id!=$module_id)
                        {
                            if ($model->module->module_id!==null)
                            {
                                $model->module->delete();
                                $model->module=null;
                            }
                        }
                        elseif(isset($model->module))//значит не добавляем
                        {
                            if (!empty($module_tree_id) || $module_tree_id == 0)
                            {
                                $model->module->delete();
                                $model->module=null;
    //                        для добавления уровня дерева
                                $module=new StructureModules();
                                $module->module_id=$module_id;
                                $module->tree_id=$module_tree_id;
                                $model->module=$module;
    //                            -------------------------------------------
                            }
                            unset($module_id);
                        }

                        if (!empty($module_id))
                        {
                            $module = new StructureModules();
                            $module->module_id = $module_id;
                            $model->module = $module;
                        }
                    }

                    /*module end*/

                    if ($model->getIsNewRecord())
                    {
                        if (($id_parent=Yii::app()->request->getParam('parent'))===null)
                        {
                            $criteria = new CDbCriteria();

                            if ($model->hasAttribute('language_id'))
                            {
                                $criteria->condition='language_id=:language_id';
                                $criteria->params[':language_id']=$this->controller->getCurrentLanguage()->id;
                            }

                            if($root=$model::model()->roots()->find($criteria))
                            {
                                if ($root->hasAttribute('status') && $root->status!=$root::STATUS_OK)
                                {
                                    $root->status=$root::STATUS_OK;
                                    $root->saveNode(false);
                                }
                                $id_parent=$root->id;
                            }
                            else
                            {
                                $root_model = $this->getModel();
                                $root_model->title = Yii::t('app', 'Root');
                                if ($root_model->hasAttribute('status'))
                                {
                                    $root_model->status=$root_model::STATUS_OK;
                                }
                                $root_model->saveNode(false);
                                $id_parent=$root_model->id;
                            }
                        }
                        if (isset($id_parent))
                        {
                            $parent=$model::model()->findByPk($id_parent);
                            if(isset($parent))
                            {
                                if ($model->isNewRecord)
                                {
                                    if (isset($_POST['parent_layout']) && $_POST['parent_layout']==1) //применить родительский template
                                    {
                                        $model->layout=$parent->layout;
                                    }
                                    if (isset($_POST['parent_widgets']) && $_POST['parent_widgets']==1)  //применить родительские widgets
                                    {
                                        $temp_widgets=array();
                                        foreach($parent->widgets as $widget)
                                        {
                                            $temp_widgets[]=clone $widget;
                                        }
                                        $model->widgets=array_merge($model->widgets,$temp_widgets);
                                    }
                                }

                                $model->appendTo($parent);
                            }
                            else
                            {
                                throw new CHttpException(404,Yii::t('base','The specified record cannot be found.'));
                            }
                        }
                        else
                        {
                            throw new CHttpException(404,Yii::t('base','The specified record cannot be found.'));
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

                         //обработка родительской категории

                        if (!$model->isRoot())
                        {
                            $parent=$model->parent()->find()->id;
                        }

                        if (!$model->isRoot() && !empty($_POST['parent_id']) && $parent!=$_POST['parent_id']) //если не совпадает родитель, то требуется переместить
                        {
                            $parent = $model::model()->notDeleted()->findByAttributes(array('id' => $_POST['parent_id'], 'language_id' => $model->language_id));

                            if ($parent)
                            {
                                $model->moveAsLast($parent); //перемещаем в конец
                            }
                        }
                        else
                        {
                            $model->saveNode(false);
                        }
                    }
                    if ($this->model->getIsNewRecord())
                    {
                        $this->redirect();
                    }
                    else
                    {

                        Yii::app()->user->setFlash('success', Yii::t('app','Saved'));
                        $this->refresh();
                    }
                }
            }

            $ug = new UrlManagerGenerator();
            $ug->recompileUrlManger();

            $this->render(array('model' => $model));
        }
    }
