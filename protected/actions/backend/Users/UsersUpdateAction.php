<?php
class UsersUpdateAction extends BackendAction
{
        
    public function run($id)
    {     
        $model = $this->getModel();
        $model->setOldPass($model->password);
        if(isset($_POST[$this->modelName]))
        {
            $model->attributes = $_POST[$this->modelName];
            if (empty($model->password))
            {
                $model->password=$model->getOldPass();
				$model->password_confirm=$model->getOldPass();
            }
			else
			{
				$model->scenario='update_password';
			}
            if ($model->validate())
            {
                $model->save(false);
                if ($this->scenario=='insert')
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
        
        $this->render(array('model' => $model));
     }
}
?>
