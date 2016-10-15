<?php
    ob_start();

    $this->widget('system.web.widgets.CTreeView',
        array(
            'cssFile' => Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.treeview')).'/jquery.treeview.css',
            'data' => $this->getLeftMenuModal(),
            'id' => 'modal_tree'
        )
    );

    $content = ob_get_contents();

    ob_end_clean();

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_releated',
            'htmlOptions' => array(
                'class' => 'modal modal_orders',
                'data-id' => '1'
            ),
            'header'  => "Выберите товары",
            'content' => $content,
            'closeText' => '<img src="/images/icon-admin/modal-close.png">',
        )
    );

    $cs = Yii::app()->getClientScript();

    $products_index_orders = '
        $("#modal_releated").on("shown.bs.modal", function (e)
        {
            var order = $(".add-product").data("id");
            $.ajax(
            {
                url: "/admin/orders/orders_add_products/",
                type: "POST",
                data: "orders="+order,
                success: function(e)
                {
                    $("#modal_releated .modal-body").find(".products").remove();
                    $("#modal_releated .modal-body").append("<div class = \"products\"> </div>");
                    $("#modal_releated .modal-body .products").html(e);
                    $("#modal_tree").css("overflow", "visible");
                }
            });
            return false;
        })
    ';

    $cs->registerScript("products_index_orders", $products_index_orders);