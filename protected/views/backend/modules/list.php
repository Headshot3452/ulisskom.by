<?php
/* @var $this ModulesController */
/* @var $model Modules */

$this->widget('bootstrap.widgets.BsGridView', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'id'=>'menu-list',
    'columns'=>array(
        array(
            'name'=>'title',
        ),
         array(
            'name'=>'version',
        ),
        array(
            'name'=>'info',
        ),
        array(
            'name'=>'type',
        ),
        array(
            'class'=>'bootstrap.widgets.BsButtonColumn',
        ),
    ),
));
?>

