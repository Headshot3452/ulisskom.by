<?php
    class OrdersAddProductsAction extends BackendAction
    {
        public function run()
        {
            $page = 0;

            if(isset($_POST['category_id']))
            {
                $category_id = $_POST['category_id'];
            }

            if (isset($_POST['page']))
            {
                $page = $_POST['page'];
            }

            $orders = isset($_POST['orders']) ? $_POST['orders'] : '';

            $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;

            if(isset($category_id))
            {
                $this->renderPartial('//catalog/_products_releated_select', array('model' => CatalogProducts::model()->notDeleted()->onlyOneParent($category_id), 'category_id' => $category_id, 'count' => $count, 'page' => $page, 'orders' => $orders));
            }
            else
            {
                $this->renderPartial('//catalog/_products_releated_select', array('model' => CatalogProducts::model()->notDeleted()->allRelated(), 'count' => $count, 'order' => 'parent_id', 'page' => $page, 'orders' => $orders));
            }
        }
    }
