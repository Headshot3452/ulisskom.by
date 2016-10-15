<?php
/* @var $this ArticlesController */
/* @var $model Articles */
?>
<?php
ob_start();
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
            'name'=>'create_time',
            'value'=>'$data->create_time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->create_time) : ""',
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
$tab_1=ob_get_contents();
ob_end_clean();

$this->widget('bootstrap.widgets.BsNavs',array(
    'items'=>array(
        array(
            'label'=>Yii::t('app','Articles'),
            'content'=>$tab_1,
            'active'=>true
        ),
    )
));
?>