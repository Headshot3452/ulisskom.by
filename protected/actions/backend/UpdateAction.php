<?php
    class UpdateAction extends BackendAction
    {
        public function run()
        {
            $model = $this->getModel();

            if(isset($_POST[$this->modelName]))
            {
                $model->attributes = $_POST[$this->modelName];
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
