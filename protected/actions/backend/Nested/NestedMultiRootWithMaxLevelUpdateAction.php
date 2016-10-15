<?php

class NestedMultiRootWithMaxLevelUpdateAction extends Action
{
    public function run()
    {

        $model = $this->getModel();
        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($model->validate()) {
                if ($model->getIsNewRecord()) {
                    $id_parent = Yii::app()->request->getParam('parent');
                    if ($id_parent !== null) {
                        $parent = $model::model()->findByPk($id_parent);
                        if ($parent) {
                            if ($parent->level < $this->getModel()->max_level) {
                                $model->appendTo($parent);
                            } else {
                                Yii::app()->user->setFlash('modal', Yii::t('app', 'The maximum level is reached'));
                                $this->refresh();
                            }
                        } else {
                            throw new CHttpException(404, Yii::t('base', 'The specified record cannot be found.'));
                        }
                    } else {
                        $model->saveNode();
                    }
                } else {
                    if ($model->hasAttribute('status')) {
                        if ($model->status == model::STATUS_DELETED) {
                            NestedSetHelper::nestedSetChildrenStatus($model);
                        }
                    }
                    $model->saveNode(false);
                }
                if ($this->model->getIsNewRecord()) {
                    $this->redirect();
                } else {
                    Yii::app()->user->setFlash('modal', Yii::t('app', 'Saved'));
                    $this->refresh();
                }
            }
        }

        $this->render(array('model' => $model));
    }
} 