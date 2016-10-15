<?php
class NestedUpAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();
        $model_name=$this->getModelName();

        $condition='lft<:lft and level=:level';
        $params=array(':lft'=>$model->lft,':level'=>$model->level);

        if ($model->hasAttribute('root'))
        {
            $condition.=' and root=:root';
            $params[':root']=$model->root;
        }

        $prev=$model_name::model()->notDeleted()->find(array(
                        'condition'=>$condition,
                        'order'=>'lft DESC',
                        'params'=>$params
                    ));
        if ($prev)
        {
            $model->moveBefore($prev);
        }
       $this->controller->redirect(Yii::app()->request->urlReferrer);
    }
}
?>
