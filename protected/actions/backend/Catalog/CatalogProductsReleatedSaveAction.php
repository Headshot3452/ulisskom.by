<?php
    class CatalogProductsReleatedSaveAction extends BackendAction
    {
        public function run()
        {
            if(!empty($_POST['checkbox']))
            {
                $products  = array_keys($_POST['checkbox']);
                $product_id = $_POST['product_id'];

                $criteria = new CDbCriteria();
                $criteria->select = 'MAX(`sort`) as `sort`';
                $criteria->condition = '`product_id` = :product_id';
                $criteria->params = array(':product_id' => $product_id);
                $sort = ProductsReleated::model()->active()->find($criteria);
                $sort = $sort->sort + 1;

                foreach ($products as $value)
                {
                    $new_model = new ProductsReleated();
                    $new_model->product_id = $product_id;
                    $new_model->releated_id = $value;
                    $new_model->sort = $sort;
                    $new_model->save();
                    $sort++;
                    unset($new_model);
                }
            }
        }
    }
