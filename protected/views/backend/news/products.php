<?php
    $this->renderPartial('_list_products_2',
        array(
            'model' => $model,
            'category_id' => $category_id,
            'count' => $count,
            'count_item' => $count_item,
            'sorter' => $sorter
        )
    );