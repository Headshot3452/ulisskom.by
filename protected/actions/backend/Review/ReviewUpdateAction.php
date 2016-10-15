<?php

class ReviewUpdateAction extends BackendAction
{
    public function run($id)
    {
        $this->controller->layout_in='backend_one_block';
        $model = new ReviewItem();
        $item = $model->with(array('theme'))->language($this->controller->getCurrentLanguage()->id)->findByPk($id);

        if(isset($_POST['ReviewItem']))
        {
            $item->attributes = $_POST['ReviewItem'];
            if($item->save())
            {
                Yii::app()->user->setFlash('modal', Yii::t('app','Product has been saved'));
                $this->redirect($this->controller->createUrl('update').'?id='.$id);
            }
        }

        $this->render(array('model'=>$model, 'data'=>$item));
    }

}