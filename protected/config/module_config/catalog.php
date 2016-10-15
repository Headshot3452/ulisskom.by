<?php
return array(
    'urlManager'=>array(
        ""=>"catalog/index",
        "search"=>"catalog/search",
        "<url:([0-9a-z\/_-]+)>/"=>"catalog/tree",
    ),
    'actions'=>array(
        'tree'=>'Список товаров',
        'product'=>'Товар',
    ),
);