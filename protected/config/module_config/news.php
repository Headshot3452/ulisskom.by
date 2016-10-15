<?php
    return array(
        'urlManager' => array(
            ''=>'news/list',
            '<name:([\w-]+)>/'=>'news/item',
        ),
        'actions'=>array(
            'item'=>'Новость',
        ),
    );