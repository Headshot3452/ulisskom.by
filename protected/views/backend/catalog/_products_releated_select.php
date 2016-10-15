<?php
    if(!isset ($order))
    {
        $order = '';
    }
    if(!isset($orders))
    {
        $orders = 0;
    }

    $header  = '<div class="buttons_group">';
    $header .= '<div class="btn-group checkbox">
                    <button type="button" class="btn checkbox-action">-</button>
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                </div>
    ';

    $cs = Yii::app()->getClientScript();
    $dataProducts = $model->language($this->getCurrentLanguage()->id)->search($count, $order, $page);
    $typeCatalog = 'small';

    $this->widget('application.widgets.ProductListViewAdmin',
        array(
            'id' => 'products-list',
            'htmlOptions' => array(
                'class' => $typeCatalog
            ),
            'typeCatalog' => $typeCatalog,
            'itemView' => '//catalog/_product_one_for_list',
            'dataProvider' => $dataProducts,
            'ajaxUpdate' => false,
            'template' => $header."{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center\">{pager}</div></div>",
            'pager' => array(
                'class' => 'bootstrap.widgets.BsPager',
                'firstPageLabel' => '<<',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'lastPageLabel' => '>>',
                'hideFirstAndLast' => true,
            ),
        )
    );

    echo CHtml::hiddenField('orders', $orders);
?>

<div class="form-group buttons">
    <?php echo BsHtml::submitButton(Yii::t('app','Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'class' => 'save save_releated')); ?>
    <span>Отмена</span>
</div>

<form method="POST" class="copy" data-module="catalog">

</form>