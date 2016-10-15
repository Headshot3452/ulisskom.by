<?php
    /* @var $this CatalogProductsController */
    /* @var $model CatalogProducts */

    echo '<a href="'.$this->createUrl('create_product').'?tree_id='.$category_id.'" class="btn btn-small"><span class="icon-admin-add-document"></span></a>';

    $this->widget('bootstrap.widgets.BsGridView',
        array(
            'dataProvider' => $model->language($this->getCurrentLanguage()->id)->search(),
            'filter' => $model,
            'id' => 'product-list',
            'columns' => array(
                array(
                    'name' => '',
                    'value' => '$data->gridImage($data->getOneFile("small"))',
                    'type' => 'raw',
                    'filter' => '',
                ),
                array(
                    'name' => '',
                    'value' => 'false',
                    'type' => 'checkbox',
                    'filter' => '',
                ),
                array(
                    'name' => Yii::t('app', 'Title'),
                    'value' => '$data->title',
                    'type' => 'url',
                    'filter' => '',
                ),
                array(
                    'name' => Yii::t('app', 'Price'),
                    'value' => '$data->price',
                    'type' => 'raw',
                    'filter' => '',
                ),
                array(
                    'name' => Yii::t('app', 'Text'),
                    'type' => 'raw',
                    'value' => '$data->text',
                    'filter' => '',
                ),
                array(
                    'class' => 'bootstrap.widgets.BsButtonColumn',
                    'template' => '{update}{delete}',
                    'buttons' => array(
                        'update' => array(
                            'url' => 'Yii::app()->controller->createUrl("catalog/update_product", array("id" => $data->id))',
                        ),
                        'delete' => array(
                            'url' => 'Yii::app()->controller->createUrl("catalog/delete_product", array("id" => $data->id))',
                        ),
                    ),

                ),

            ),
        )
    );