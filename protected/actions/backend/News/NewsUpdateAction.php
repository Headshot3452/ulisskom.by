<?php
    class NewsUpdateAction extends BackendAction
    {
        public function run($tree_id = null)
        {
            $model = $this->getModel();

            if(!empty($_GET['id']))
            {
                $id = (int)htmlspecialchars($_GET['id']);
                $this->controller->addButtonsRightMenu('status',
                    array(
                        'url' => $this->controller->createUrl('update_status').'?id='.$id,
                        'active' => (News::model()->findByPk($id)->status == NewsTree::STATUS_OK) ? true : false,
                    )
                );

                $this->controller->addButtonsRightMenu('delete',
                    array(
                        'url' => $this->controller->createUrl('delete').'?id='.$id,
                        'active' => (News::model()->findByPk($id)->status == NewsTree::STATUS_OK) ? true : false,
                    )
                );
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
                $sort = News::model()->active()->find($criteria);
                $model->sort = $sort->sort + 1;
            }

            $tree = NewsTree::model()->findByPk($tree_id);

            if ($tree === null)
                throw new CHttpException(404);

            if(isset($_POST['News']))
            {
                $model->attributes = $_POST['News'];

                if($model->save())
                {
                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );
                    $this->redirect($this->controller->createUrl('update',array('id' => $model->id)));
                }
            }
            $this->render(array('model' => $model));
        }
    }