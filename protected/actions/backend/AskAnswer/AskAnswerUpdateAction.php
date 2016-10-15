<?php
    class AskAnswerUpdateAction extends BackendAction
    {
        public function run($tree_id=null)
        {
            $model = $this->getModel();

            if(isset($_GET['parent'])){
                $this->controller->_active_category_id=$_GET['parent'];
            }

            if (!$model->isNewRecord)
            {
                $id = $model->id;

                $params = array('id' => $id, 'type' => 'status');
                $this->controller->addButtonsRightMenu('status',
                    array(
                        'url' => $this->controller->createUrl('update', $params),
                        'active' => ($model->status == $model::STATUS_OK) ? true : false
                    )
                );

                $params = array('id' => $id, 'type' => 'delete');
                $this->controller->addButtonsRightMenu('delete',
                    array(
                        'url' => $this->controller->createUrl('update', $params)
                    )
                );
            }

            if(isset($_GET['type']))
            {
                if($_GET['type'] == 'status')
                {
                    if ($model->hasAttribute('status'))
                    {
                        if ($model->status == $model::STATUS_OK)
                        {
                            $model->status = $model::STATUS_NOT_ACTIVE;
                        }
                        else
                        {
                            $model->status = $model::STATUS_OK;
                        }
                    }
                }
                if($_GET['type'] == 'delete')
                {
                    $model->status = $model::STATUS_DELETED;
                }
                $model->save(false, 'status');
                $this->redirect($this->controller->createUrl('update', array('id' => $model->id)));
            }

            $this->controller->setActiveCategoryId($model->parent_id);

            $this->controller->addButtonsLeftMenu('create',
                array(
                    'url' => $this->controller->createUrl('create_category').'?parent='.$model->parent_id
                )
            );

            if ($tree_id === null)
            {
                $tree_id = $model->parent_id;
            }
            elseif($model->isNewRecord)
            {
                $model->parent_id = $tree_id;
                $criteria = new CDbCriteria();
                $criteria->select = 'MAX(`sort`) as `sort`';
                $criteria->condition = '`parent_id` = :parent_id';
                $criteria->params = array(':parent_id' => $model->parent_id);
                $sort = AskAnswer::model()->active()->find($criteria);
                $model->sort = $sort->sort + 1;
            }

            $tree = AskAnswerTree::model()->findByPk($tree_id);

            if ($tree === null)
            {
                throw new CHttpException(404);
            }

            if(isset($_POST['AskAnswer']))
            {
                $model->attributes = $_POST['AskAnswer'];
                $model->title = strip_tags($model->title);
                $model->answer_ok = ($_POST['answer_ok'] == 1) ? 1 : 0;

                if($model->save())
                {
                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );
                    $this->redirect($this->controller->createUrl('update', array('id' => $model->id)));
                }
            }
            $this->render(array('model' => $model));
        }
    }