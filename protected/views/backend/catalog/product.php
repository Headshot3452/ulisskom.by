<div class="form">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'catalog-products-product-form',
            'enableAjaxValidation' => false,
        )
    );

    echo BsHtml::tabs(
        array(
            array(
                'label' => Yii::t('app', 'Description'),
                'url' => '#Description',
                'active' =>true,
            ),
            array(
                'label'=> Yii::t('app', 'Parameters'),
                'url' => '#Parameters',
                'active'=>false,
            ),
            array(
                'label' => Yii::t('app', 'Products releated'),
                'url' => '#Products_releated',
                'active' => false,
            ),
            array(
                'label' => Yii::t('app', 'Reviews'),
                'url' => '#Products_review',
                'active' => false,
            ),
        )
    );
?>
    <div class="tab-content">
        <div class="tab-pane active row" id="Description">
            <?php echo $this->renderPartial('_form_product', array('model' => $model, 'form' => $form, 'sale' => unserialize($model->sale_info), 'stock' => unserialize($model->stock)), true, false); ?>
        </div>
        <div class="tab-pane row" id="Parameters">
            <?php echo $this->renderPartial('_form_product_parameters', array('params' => $params, 'form' => $form, 'item_params' => $item_params)); ?>
        </div>
        <div class="tab-pane row" id="Products_releated">
            <?php echo $this->renderPartial('_form_products_releated',array('products_releated' => $products_releated)); ?>
        </div>
        <div class="tab-pane row" id="Products_review">
            <?php echo $this->renderPartial('_form_products_review',array('products_review' => $products_review, 'form' => $form, 'count_item' => $count_item)); ?>
        </div>
    </div>

    <div id="_modal_reviews_container">

    </div>

<?php
    $this->renderPartial('_modal_releated');
    $this->renderPartial('_modal_reviews');


    $cs = Yii::app()->getClientScript();

    $tabs = '
        $(".nav-tabs a").click(function (e)
        {
            e.preventDefault()
            $(this).tab("show")
        })
    ';

    $cs->registerScript("tabs", $tabs);
?>
    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div>

<form method="POST" class="copy" data-module="catalog">

</form>

