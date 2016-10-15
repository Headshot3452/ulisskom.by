<?php
/* @var $data Structure */
?>
<div class="items">
    <div class="login"><?php  echo CHtml::link(CHtml::encode($data->title),array('update','id'=>$data->id)); ?></div>
    <div class="status"><?php echo CHtml::encode($data->getStatus($data->status)); ?></div>
</div>
