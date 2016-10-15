<?php
    $this->renderPartial('index',
        array(
            'model' => $model, 'count' => $count, 'count_item' => $count_item
        )
    );