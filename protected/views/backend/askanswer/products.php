<?php
    $this->renderPartial('_list_products_2',
        array('dataProducts' => $dataProducts, 'category_id' => $category_id, 'count' => $count, 'count_item' => $count_item)
    );