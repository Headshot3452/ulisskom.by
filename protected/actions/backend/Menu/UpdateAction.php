<?php
class UpdateAction extends BackendAction
{

    public function run($id=null)
    {
        if(isset($_GET['id'])){
            $model = $this->getModel();
            
        }
        else
            $model = new MenuItem();

        $this->controller->_active_category_id=$id;

        if(isset($_GET['parent'])){
            $this->controller->_active_category_id=$_GET['parent'];
        }

        $setBreadcrumb=true;

        if ($model->getIsNewRecord())
        {
            $title=Yii::t('app','Новый пункт меню').' '.$model->title;
        }
        else
        {
            $title=Yii::t('app','Редактирование.').' '.$model->title.'.';
        }

        if ($setBreadcrumb)
        {
            $this->controller->setLastBreadcrumb($title);
        }

        $this->controller->setPageTitle($title);

        if (!$model)
        {
            throw new CHttpException(404);
        }

        $params=array();

        if (!$model->isNewRecord)
        {
            $id=$model->id;

            $params=array('id'=>$id);

                $this->controller->addButtonsLeftMenu('active', array(
                        'url'=>$this->controller->createUrl('active',$params),
                        'active'=>($model->status==$model::STATUS_OK) ? true : false)
                );
                $this->controller->addButtonsLeftMenu('delete',array(
                        'url'=>$this->controller->createUrl('delete',$params)
                    )
                );

            $params=array('parent'=>$id);
        }

        $this->controller->addButtonsLeftMenu('create_menu', array(
                'url'=>$this->controller->createUrl('update',$params),
            )
        );

        if(isset($_POST[$this->modelName]))
        {   
            $model->attributes = $_POST[$this->modelName];
            $model->status = 1;

            $id_parent=$model->parent_id;
            if($id_parent==0)
            {
                $id_parent=Yii::app()->request->getParam('parent');
            }

            if($model->validate())
            {
                if ($model->getIsNewRecord())
                {
                    if ($id_parent!==null && $id_parent!=0)
                    {
                        $parent=MenuItem::model()->findByPk($id_parent);
                        if($parent)
                        {
                            $model->appendTo($parent);

                            if($model->level != 2)
                            {
                                $model->parent_id = $id_parent;
                                $model->saveNode(false);
                            }
                            else
                            {
                                $model->parent_id = null;
                                $model->saveNode(false);
                            }
                        }
                        else
                        {
                            throw new CHttpException(404,Yii::t('base','The specified record cannot be found.'));
                        }
                    }
                    else
                    {
                        $criteria = new CDbCriteria();

                        $criteria->select = 'MAX(`id`) as `id`';
                        $id = MenuItem::model()->active()->find($criteria);

                        $model->parent_id = $id->id + 1;
                        $model->saveNode(false);
                    }
                }
                else
                {
                    if (!$model->isRoot())
                    {
                        $parent=$model->parent()->find()->id;
                    }

                    if (!$model->isRoot() && !empty($id_parent) && $parent!=$id_parent) //если не совпадает родитель, то требуется переместить
                    {
                        $parent=MenuItem::model()->findByPk($id_parent);

                        if($id_parent==0)
                        {
                            $model->moveAsRoot();
                        }
                        else
                            if ($parent)
                            {
                                $model->moveAsLast($parent); //перемещаем в конец

                                if($model->level != 2)
                                {
                                    $model->parent_id = $id_parent;
                                }
                                else if($model->level == 2)
                                {
                                    $model->parent_id = null;
                                }

                                $model->saveNode(false);
                            }
                    }
                    else
                    {
                        $model->saveNode(false);
                    }
                }

                if ($model->getIsNewRecord())
                {
                    Yii::app()->user->setFlash('success', Yii::t('app','Saved'));
                    $this->redirect();
                }
                else
                {
                    Yii::app()->user->setFlash('success', Yii::t('app','Saved'));
                    $this->refresh();
                }
            }
         }

        $this->render(array('model' => $model));
     }
}
?>
