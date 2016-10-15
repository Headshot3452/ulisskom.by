<?php
    class OrdersAddProductsSaveAction extends BackendAction
    {
        public function run()
        {
            if(!empty($_POST['checkbox']) && !empty($_POST['orders']))
            {
                $products = array_keys($_POST['checkbox']);
                $order_id = $_POST['orders'];

                foreach ($products as $value)
                {
                    $product = CatalogProducts::model()->active()->findByPk($value);

                    if (!$product)
                    {
                        throw new CHttpException(404);
                    }

                    $new_model = new OrderItems();
                    $new_model->product_id = $product->id;
                    $new_model->order_id = $order_id;
                    $new_model->title = $product->title;
                    $new_model->price = $product->price;
                    $new_model->count = 1;
                    $new_model->count_edit = 0;
                    $new_model->discount = (int)$product->getSalePrice($product->price, $product->sale_info, null, '');
                    $new_model->save();
                    unset($new_model);
                }
            }
        }
    }
