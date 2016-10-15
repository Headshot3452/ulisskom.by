<?php
/* @var $this NewsController */
/* @var $model News */
?>
<?php
$this->widget('bootstrap.widgets.BsGridView', array(
    'dataProvider'=>$model->language($this->getCurrentLanguage()->id)->search(),
    'filter'=>$model,
    'id'=>'users-list',
    'columns'=>array(

        array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'CHtml::link($data->title,array("update","id"=>$data->id))',
        ),

        array(
            'name'=>'time',
            'value'=>'$data->time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->time) : ""',
        ),

        array(
            'name'=>'create_time',
            'value'=>'$data->create_time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->create_time) : ""',
        ),

        array(
            'name'=>'status',
            'value'=>'$data->getStatus($data->status)',
        ),
        array(
            'class'=>'bootstrap.widgets.BsButtonColumn',
        ),
    ),
));
?>