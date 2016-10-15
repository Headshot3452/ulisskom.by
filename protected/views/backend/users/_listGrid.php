<?php
/* @var $this UsersController */
/* @var $model Users */
?>
<?php
$this->widget('bootstrap.widgets.BsGridView', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'id'=>'users-list',
    'columns'=>array(
         array(
            'name'=>'avatar',
            'value'=>'$data->gridImage($data->avatar,$data->login)',
            'type'=>'raw',
            'filter'=>'',
        ),
        array(
            'name'=>'login',
            'type'=>'raw',
            'value'=>'CHtml::link(Chtml::encode($data->login),array("update","id"=>$data->id))',
        ),
         array(
            'name'=>'email',
        ),
        array(
            'name'=>'create_time',
            'value'=>'$data->create_time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->create_time) : ""',
        ),
         array(
            'name'=>'update_time',
            'value'=>'$data->update_time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->update_time) : ""',
        ),
        array(
            'name'=>'role',
            'value'=>'$data->getRole($data->role)',
            'filter'=> $model->getRole(),
        ),
        array(
            'name'=>'status',
            'value'=>'$data->getStatus($data->status)',
            'filter'=>$model->getStatus(),
        ),
        array(
            'class'=>'bootstrap.widgets.BsButtonColumn',
        ),
    ),
));
?>