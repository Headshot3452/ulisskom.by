<?php
/* @var $data Users */
?>
<div class="row items">
    <div class="avatar"><?php echo $data->gridImage($data->avatar,$data->login); ?></div>
    <div class="login"><?php  echo  CHtml::link(CHtml::encode($data->login),array('update','id'=>$data->id)); ?></div>
    <div class="email"><?php echo  CHtml::encode($data->email); ?></div>
    <div class="role"><?php echo  CHtml::encode($data->getRole($data->role)); ?></div>
    <div class="status"><?php echo CHtml::encode($data->getStatus($data->status)); ?></div>
</div>
