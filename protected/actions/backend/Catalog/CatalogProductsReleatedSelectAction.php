<?php
    class CatalogProductsReleatedSelectAction extends BackendAction
    {
        public function run()
        {
            $page = 0;

            if(isset($_POST['category_id']))
            {
                $category_id = $_POST['category_id'];
            }
            if (isset($_POST['product_id']))
            {
                $product_id = $_POST['product_id'];
            }
            if (isset($_POST['page']))
            {
                $page = $_POST['page'];
            }

            $keys_array = array();

            if(isset($product_id) && $product_id != 'undefined')
            {
                $releated_products = ProductsReleated::getReleatedProducts($product_id);

                foreach ($releated_products as $value)
                {
                    $keys_array[] = $value->releated_id;
                }
            }
            else
            {
                $product_id = 0;
            }

            $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;

            if(isset($category_id))
            {
                $this->renderPartial('_products_releated_select', array('model' => CatalogProducts::model()->notDeleted()->onlyOneParent($category_id, $product_id, $keys_array), 'category_id' => $category_id, 'count' => $count, 'page' => $page));
            }
            else
            {
                $this->renderPartial('_products_releated_select', array('model' => CatalogProducts::model()->notDeleted()->allRelated($product_id, $keys_array), 'count' => $count, 'order' => 'parent_id', 'page' => $page));
            }
        }
    }
