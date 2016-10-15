<?php
return array(
    'urlManager'=>array(
        ''=>'articles/list',
        '<name:([\w-]+)>/'=>'articles/item',
    ),
    'actions'=>array(
        'item'=>Yii::t('app','Article'),
    ),
);