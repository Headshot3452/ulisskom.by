<?php
    /* @var $this StructureController */
    /* @var $model Structure */

    $this->widget('bootstrap.widgets.BsGridView',
        array(
            'dataProvider'   => $model->search(),
            'filter'         => $model,
            'id'             => 'users-list',
            'columns'        => array(
                array(
                    'name'   => 'title',
                ),
                array(
                    'name'   => 'name',
                ),
                array(
                    'name'   => 'create_time',
                    'value'  => '$data->create_time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->create_time) : ""',
                ),
                 array(
                    'name'   => 'update_time',
                    'value'  => '$data->update_time!=null ? Yii::app()->dateFormatter->format("d MMM y",$data->update_time) : ""',
                ),
                array(
                    'name'   => 'status',
                    'value'  => '$data->getStatus($data->status)',
                    'filter' => $model->getStatus(),
                ),
                array(
                    'class'  => 'bootstrap.widgets.BsButtonColumn',
                ),
            ),
        )
    );