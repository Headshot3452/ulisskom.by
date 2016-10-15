<?php
/* @var $this BannersController */
/* @var $model Banners */
?>
<?php

echo BsHtml::link(Yii::t('app','Create block'),array('create'),array('class'=>'btn btn-'.BsHtml::BUTTON_COLOR_PRIMARY));

$this->widget('bootstrap.widgets.BsGridView', array(
    'dataProvider'=>$model->language($this->getCurrentLanguage()->id)->search(),
    'filter'=>$model,
    'id'=>'users-list',
    'columns'=>array(
         array(
            'name'=>'title',
            'value'=>'$data->title',
            'type'=>'raw',
            'filter'=>'',
        ),
        array(
            'name'=>'text',
            'type'=>'raw',
            'value'=>'Core::cutString($data->text,128)',
            'filter'=>'',
        ),
        array(
            'class'=>'bootstrap.widgets.BsButtonColumn',
            'template'=>'{update}{delete}',
        ),
    ),
));
?>