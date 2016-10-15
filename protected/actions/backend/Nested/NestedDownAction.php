<?php
class NestedDownAction extends BackendAction
{
    public function run()
    {
        $model=$this->getModel();
        $model_name=$this->getModelName();

        $condition='lft>:lft and level=:level';
        $params=array(':lft'=>$model->lft,':level'=>$model->level);

        if ($model->hasAttribute('root'))
        {
            $condition.=' and root=:root';
            $params[':root']=$model->root;
        }

        $next=$model_name::model()->notDeleted()->find(array(
            'condition'=>$condition,
            'params'=>$params
        ));

        if ($next)
        {
            $model->moveAfter($next);
        }
        $this->controller->redirect(Yii::app()->request->urlReferrer);
    }
}
?>
