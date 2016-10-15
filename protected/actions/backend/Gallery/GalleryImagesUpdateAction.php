<?php
class GalleryImagesUpdateAction extends BackendAction
{
    public function run($tree_id=null)
    {
        $model = $this->getModel();
        //      �����-�� ����
        $this->controller->setActiveCategoryId($model->parent_id);
        //      --------------------------------

        $this->controller->addButtonsLeftMenu('create', array(
                'url'=>$this->controller->createUrl('create_gallery').'?parent='.$model->parent_id
            )
        );

        if ($tree_id===null)
        {
            $tree_id=$model->parent_id;
        }
        elseif($model->isNewRecord)
        {
            $model->parent_id=$tree_id;
            $model->parent=$model->getInstanceRelation('parent')->findByPk($tree_id);
            $criteria = new CDbCriteria();
            $criteria->select = 'MAX(`sort`) as `sort`';
            $criteria->condition = '`parent_id`=:parent_id';
            $criteria->params = array(':parent_id' => $model->parent_id);
            $sort = GalleryImages::model()->active()->find($criteria);
            $model->sort = $sort->sort + 1;
        }

        $tree=GalleryTree::model()->findByPk($tree_id);

        if ($tree===null)
            throw new CHttpException(404);

        if(isset($_POST['GalleryImages']))
        {
            $model->attributes=$_POST['GalleryImages'];
            if($model->validate())
            {
                $model->save(false);
                Yii::app()->user->setFlash('modal', Yii::t('app','Product has been saved'));
                $this->redirect($this->controller->createUrl('update_product',array('id'=>$model->id)));
            }
        }

        if(!$model->isNewRecord)
        {
            $this->controller->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('',$this->controller->createUrl('index'));
            $this->controller->pageTitleBlock.= $this->controller->renderPartial('_image_one_for_head_title', array('data'=>$model), true);
        }
        $this->render(array('model'=>$model));
    }


}