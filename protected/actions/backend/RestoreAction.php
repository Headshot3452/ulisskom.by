<?php
class RestoreAction extends BackendAction
{
     public function run()
    {
        Yii::app()->user->setFlash('success', 'Сохранено');
     }
}
?>
