<?php
class ListAction extends BackendAction
{
     public function run()
    {
        $model = $this->getModel();
        if(isset($_GET[$this->modelName]))
        {
            $model->attributes = $_GET[$this->modelName];
        }
         $this->render(array('model' => $model));
    }
}
?>
