<?php
    $this->renderPartial('index',
        array(
            'model' => $model, 'count' => $count, 'sorter' => $sorter, 'count_item' => $count_item
        )
    );