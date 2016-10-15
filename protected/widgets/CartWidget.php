<?php
    class CartWidget extends Portlet
    {
        public function renderContent()
        {
            echo
                '<div id="cart"></div>
                <script id="template-cart" type="ractive/text">
                    <table class="table table-hover border-bottom products">
                        <thead>
                            <tr class="gray-color">
                                <th>#</th>
                                <th>Фото товара</th>
                                <th>Наименование</th>
                                <th>Цена/Скидка</th>
                                <th>Кол-во</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center"><span class="fa fa-trash"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{#products:i}}
                            <tr>
                                <td>
                                    {{i+1}}
                                </td>
                                <td>
                                    <img class="img-thumbnail" src="/{{image}}">
                                </td>
                                <td style="max-width: 375px;">
                                    <div>{{title}}</div>
                                    <span class="gray-color id">#{{id}}</span>
                                </td>
                                <td>
                                    <div class="price">
                                        <b>
                                            {{price}}
                                        </b>
                                        <span class="text-uppercase gray-color">Byr</span>
                                    </div>
                                    <div class="discount red-color">
                                        <b>
                                            {{#if(sale && sale != price && !type)}}
                                                {{parseFloat(100 - (sale * 100) / price).toFixed(2)}}
                                            {{/if}}
                                            {{#if(sale && sale != price && type)}}
                                                {{parseFloat(price - sale).toFixed(2)}}
                                            {{/if}}
                                            {{#if(!sale)}}
                                                0.00
                                            {{/if}}
                                        </b>
                                        <span class="text-uppercase gray-color red-color">{{!type ? "%" : "Byr"}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="count-wr">
                                        <div class="count">
                                            <span class="fa fa-minus-square fa-2x primary-color" on-click="downCountItem" data-index="{{i}}"></span>
                                                '.CHtml::numberField("product-count", '{{this.count}}', array("min" => "1", "max" => "100", 'on-change' => "updateItem", 'value' => '{{this.count}}', 'id' => '{{this.count}}', 'data-index' => '{{i}}')).'
                                            <span class="fa fa-plus-square fa-2x primary-color" on-click="upCountItem" data-index="{{i}}"></span>
                                        </div>
                                        <span class="gray-color">шт.</span>
                                    </div>
                                </td>
                                <td class="text-right price_total_item">
                                    <b>{{(sale) ? parseFloat(sale * count).toFixed(2) : parseFloat(price * count).toFixed(2)}}</b> <span class="text-uppercase gray-color">Byr</span>
                                </td>
                                <td class="text-center">
                                    <span class="fa fa-close red-color delete" on-click="removeItem" data-index="{{i}}"></span>
                                </td>
                            </tr>
                            {{/products}}
                        </tbody>
                    </table>
                </script>';

            $cs = Yii::app()->getClientScript();

            $cart = '
                var CartRactive = Ractive.extend(
                {
                    onrender:function(options)
                    {
                        var self = this;
                        // proxy event handlers
                        self.on(
                        {
                            removeItem: function (e)
                            {
                                swal(
                                {
                                    title: "Удалить товар из корзины?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Да удалить!",
                                    cancelButtonText: "Нет",
                                    closeOnConfirm: false
                                },
                                function()
                                {
                                    cart.removeItem(e.index.i);
                                    swal("Удален!", "Товар удален из Вашей корзины.", "success");
                                });
                            },
                            updateItem: function (e)
                            {
                                cart.save();
                            },
                            downCountItem: function (e)
                            {
                                cart.downCountItem(e.index.i);
                            },
                            upCountItem: function (e)
                            {
                                cart.upCountItem(e.index.i);
                            }
                        });
                    }
                });

                initCartRactive();

                $.jStorage.listenKeyChange("cart", function(key, action)
                {
                    initCartRactive();
                });

                $(".price b, .price_total_item b").each(function()
                {
                    $(this).text( number_format($(this).text(), 2, ".", " ") );
                });


                function initCartRactive()
                {
                    ractive = new CartRactive(
                    {
                        el: "#cart",
                        template: "#template-cart",
                        data: {
                            products: cart.products,
                            count: cart.count,
                            total_discount: cart.total_discount,
                            total_price: cart.total_price,
                        },
                    });

                    // $("#FormModel_products").val(JSON.stringify(cart.products));
                    $("#CartForm_products").val(JSON.stringify(cart.products));
                }

                $("body").on("click", ".clear-cart", function()
                {
                    swal(
                    {
                        title: "Очистить корзину?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Да очистить!",
                        cancelButtonText: "Нет",
                        closeOnConfirm: false
                    },
                    function()
                    {
                        $.jStorage.deleteKey("cart");
                        swal("Очищена!", "Ваша корзина очищена", "success");
                    });
                });
            ';

            $cs->registerPackage('ractivejs')->registerPackage('sweet')->registerScript("cart", $cart);
        }
    }