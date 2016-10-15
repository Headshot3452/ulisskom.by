<?php

if (!isset($attr_val))
{
    $attr_val='name';
}

if (!isset($attr_id))
{
    $attr_id='id';
}

echo CHtml::tag('option',
                array('value'=>""),CHtml::encode($title),true);

foreach ($items as $item)
{
   echo CHtml::tag('option',
                   array('value'=>$item[$attr_id]),CHtml::encode($item[$attr_val]),true);
}
?>
