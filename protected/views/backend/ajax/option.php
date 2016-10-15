<?php
echo CHtml::tag('option',
                   array(),CHtml::encode($title),true);
foreach ($items as $item)
{
   echo CHtml::tag('option',
                   array('value'=>$item['id']),CHtml::encode($item['name']),true);
}
?>
