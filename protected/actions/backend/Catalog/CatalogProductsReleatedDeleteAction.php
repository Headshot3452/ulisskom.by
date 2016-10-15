<?php
    class CatalogProductsReleatedDeleteAction extends BackendAction
    {
        public function run()
        {
            if(!empty($id = $_POST['id']))
            {
                $model = ProductsReleated::model()->findByPk($id);

                if($model)
                {
                    if($model->delete())
                    {
                        unset($model);
                        echo $id;
                    }
                }
            }
        }
    }
