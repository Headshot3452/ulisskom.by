<?php
/* @var $this AskanswerController */
/* @var $model AskAnswerGroup */
?>
<?php
$this->widget('bootstrap.widgets.BsGridView', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'id'=>'askanswer-list',
    'columns'=>array(
        'title',
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