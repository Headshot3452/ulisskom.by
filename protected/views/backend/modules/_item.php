<?php
/* @var $data Modules */
?>
<div class="items">
    <div class="title"><?php  echo  CHtml::encode($data->title); ?></div>
    <div class="version"><?php CHtml::encode($data->version); ?></div>
    <div class="info"><?php echo   CHtml::encode($data->info); ?></div>
    <div class="type"><?php echo   CHtml::encode($data->type); ?></div>
</div>
