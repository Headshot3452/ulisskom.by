<?php
/* @var $this AskanswerController */
/* @var $model AskAnswer */
?>
<?php
$group=$model->getInstanceRelation('group');
$this->widget('bootstrap.widgets.BsGridView', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'id'=>'askanswer-list',
    'columns'=>array(
        array(
            'name'=>'group_id',
            'value'=>'$data->group->title',
            'filter'=>CHtml::listData($group::model()->active()->findAll(),'id','title'),
        ),
        'title',
        'text',
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