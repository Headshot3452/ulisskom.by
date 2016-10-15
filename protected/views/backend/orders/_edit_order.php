<?php
$cs=Yii::app()->getClientScript();
?>
    <div id="items-products">

    </div>
    <div class="form">
        <?php
        echo CHtml::beginForm();
        ?>
        <input type="hidden" name="products" id="input-products-list">
        <div class="form-group buttons">
            <?php echo BsHtml::submitButton(Yii::t('app','Save'),array()); ?>
        </div>
        <?php
        echo CHtml::endForm();
        ?>
    </div>

    <script id="template-products" type="ractive/text">
    <div class="items-list">
        <div class="row header">
            <div class="c-num">№</div>
            <div class="c-image">Вид</div>
            <div class="c-title">Наименование товара</div>
            <div class="c-price">Цена / скидка</div>
            <div class="c-count">Количество</div>
            <div class="c-sum">Сумма</div>
            <div class="c-status">Статус</div>
            <div class=""></div>
        </div>
        {{#products:i}}
        <div class="row order">
            <div class="c-num"><div class="cell">{{i+1}}</div></div>
            <div class="c-image"><div class="cell"><img src="/{{image}}"/></div></div>
            <div class="c-title"><div class="cell">{{title}}</div></div>
            <div class="c-price"><div class="cell">{{priceFormat(price)}}</div></div>
            <div class="c-count">
                <div class="cell"><a href="javascript:void(0);" on-click="downCountItem" data-index="{{i}}"><i class="glyphicon glyphicon-minus"></i></a><span class="input">{{count}} {{#countEdit}}({{countEdit}}){{/countEdit}}</span><a href="javascript:void(0);" on-click="upCountItem" data-index="{{i}}"><i class="glyphicon glyphicon-plus"></i></a></div>
            </div>
            <div class="c-sum"><div class="cell">{{priceFormat(totalPrice)}}</div></div>
            <div class="c-status">
                <div class="cell">
                <?php
        echo CHtml::dropdownList('status[{{i}}]','',OrderItems::getStatus(),
            array(
                'value'=>'{{status}}',
                'on-change'=>'statusChange',
            ));
        ?>
                </div>
            </div>
            <div class="">
              {{#isProductManager}}
                <a href="javascript:void(0);" data-index="{{i}}" on-click="removeItem"><i class="glyphicon glyphicon-trash"></i></a>
              {{/isProductManager}}
            </div>
        </div>
        {{/products}}
        <div class="row">
            <div class="add-link col-xs-offset-1">
                <a href="" data-toggle="modal" data-target="#modalAddProducts">
                    +Добавить товар
                </a>
            </div>
        </div>
        <div class="row footer">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4 right">
            <div class="count row">
                <div class="label col-xs-6">Количество товаров:</div>
                <div class="value col-xs-6 text-right"><b>{{count}}</b></div>
            </div>
            <div class="count row">
                <div class="label col-xs-6">Сумма:</div>
                <div class="value col-xs-6 text-right"><b>{{priceFormat(totalPrice)}}</b> <span>BYR</span></div>
            </div>
            <div class="delivery row">
                <div class="label col-xs-6">Доставка:</div>
                <div class="value col-xs-6 text-right"><b>{{priceFormat(delivery)}}</b> <span>BYR</span></div>
            </div>
        </div>
    </div>
        <div class="result row">
            <div class="col-xs-8">
            </div>
         <div class="col-xs-4">
                <div class="total_price">
                    <div class="label col-xs-6">Итого:</div>
                    <div class="value col-xs-6 text-right"><b>{{priceFormat(totalPrice+delivery)}}</b> <span>BYR</span></div>
                </div>
            </div>
         </div>
    </div>
</script>

<?php
$edit_order='

    function Product(id,product_id,title,count,countEdit,price,status,type,image)
    {
        this.getTotalPrice=function()
        {
            return parseFloat(this.getTotalCount()*this.price);
        }

        this.getTotalCount=function()
        {
            return parseInt(this.count+this.countEdit);
        }


        this.id=id;
        this.product_id=product_id;
        this.title=title;
        this.count=parseInt(count);
        this.countEdit=parseInt(countEdit);
        this.price=parseFloat(price);
        this.totalPrice=this.getTotalPrice();
        this.status=status;
        this.type=type;
        this.image=image;

        this.isProductManager=false;

        if (this.type==1)
        {
             this.isProductManager=true;
        }
    }

    var OrderProducts=function()
    {
        this.onSave=false;
        this.delivery=false; //нужна ли доставка
        this.deliveryFlag=false; //у клиента заказа на какую доставку?
        this.deliveryPrice=0; //стоймость доставки
        this.userDeliveryPrice=0; //стоймость доставки
        this.items=[];
        this.itemsById=[];
        this.count=0;
        this.totalPrice=0;
    }

    OrderProducts.prototype.addProduct=function(product)
    {
        if (product instanceof Product)
        {
            if (!this.hasProduct(product))
            {
                this.items.push(product);
                this.itemsById[product.product_id]=product.id;
                product.totalPrice=product.getTotalPrice();
                this.calculatePrice();
                this.calculateDeliveryPrice();
            }
        }
    }

    OrderProducts.prototype.hasProduct=function(product)
    {
        if (product instanceof Product)
        {
            var product_id = product.product_id;

            if (product_id=="" || this.itemsById[product_id]==undefined)
            {
                return false;
            }
            return true;
        }
    }

    OrderProducts.prototype.upCountItem=function(index)
    {
        this.items[index].countEdit++;
        this.items[index].totalPrice=this.items[index].getTotalPrice();
        this.count++;
        this.calculatePrice();
        this.calculateDeliveryPrice();

    }

    OrderProducts.prototype.downCountItem=function(index)
    {
        if (this.items[index].countEdit-1 + this.items[index].count >= 0)
        {
            this.items[index].countEdit--;
            this.items[index].totalPrice=this.items[index].getTotalPrice();
            this.count--;
            this.calculatePrice();
            this.calculateDeliveryPrice();
        }
    }

    OrderProducts.prototype.setStatus=function(index,status)
    {
         this.items[index].status=status;
         this.calculatePrice();
         this.calculateDeliveryPrice();
    }

    OrderProducts.prototype.removeItem=function(index)
    {
        delete this.itemsById[this.items[index].id];
        this.items.splice(index,1);
        this.calculatePrice();
        this.calculateDeliveryPrice();
    }

    OrderProducts.prototype.save=function()
    {
        if (this.onSave)
        {
           $("#input-products-list").val(JSON.stringify(this.items));
           $("#input-products-list").trigger("change");
        }
    }

    OrderProducts.prototype.calculatePrice=function()
    {
        var totalPrice=0;
        var count=0;
        $.each(this.items,function()
        {
            if (this.status==1)
            {
               totalPrice+=this.getTotalPrice();
               count+=this.getTotalCount();
            }
        });
        this.totalPrice=totalPrice;
        this.calculateDeliveryPrice();
        this.count=count;
    }

    OrderProducts.prototype.calculateDeliveryPrice=function()
    {
       var price;

       if (this.delivery && !this.deliveryFlag)
       {
            if (this.totalPrice>'.Orders::getDeliveryLimit().')
            {
                price=0;
            }
            else
            {
                price=this.deliveryPrice;
            }
        }
        else
        {
             price=0;
        }
        this.userDeliveryPrice=price;
    }

    OrderProducts.prototype.clean=function()
    {
       this.count=0;
       this.items=[];
       this.itemsById=[];
    }
    ';

$js_products='products = new OrderProducts;
              ';

if ($order->type_delivery==Orders::ORDER_DELIVERY_TO_ADDRESS)
{
    $js_products.='
         products.deliveryPrice='.$order->sum_delivery.';
         products.userDeliveryPrice='.$order->sum_delivery.';
         products.delivery=true;
    ';
    if ($order->sum_delivery==0)
    {
        $js_products.='
            products.deliveryFlag=true;
        ';
    }
}

foreach($products as $data)
{
    if($data->product_id)
    {
        $product = $data->product;
        $image = $data->product->getOneFile('small');
        if(!$image)
        {
            $image = Yii::app()->params['noimage'];
        }
    }
    else
    {
        $product = $data;
        $image = Yii::app()->params['noimage'];
    }
    $js_products.='products.addProduct(new Product("'.$data->id.'","'.$data->product_id.'","'.$data->title.'","'.$data->count.'","'.$data->count_edit.'","'.$data->price.'","'.$data->status.'","'.$data->product_type_add.'","'.$image.'"));';
}

$js_products.='
    products.onSave=true;
    var OrderRactive = Ractive.extend({
        onrender:function(options)
        {
            var self = this;

            function updating(obj)
            {
                obj.set("totalPrice",products.totalPrice);
                obj.update("totalPrice");
                obj.set("count",products.count);
                obj.update("count");
                obj.set("delivery",products.userDeliveryPrice);
                obj.update("delivery");
            }
            // proxy event handlers
            self.on({
                downCountItem: function (e)
                {
                    products.downCountItem(e.index.i);
                    this.update(e.keypath);
                    updating(this);
                },
                removeItem: function (e)
                {
                    var self = this;
                    swal({
                      title: "Удалить товар из корзины?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Да удалить!",
                      cancelButtonText: "Нет",
                      closeOnConfirm: false
                    },
                    function(){
                      products.removeItem(e.index.i);
                      updating(self);
                      swal("Удален!", "Товар удален из Вашей корзины.", "success");
                    });
                },
                upCountItem: function (e)
                {
                    products.upCountItem(e.index.i);
                    this.update(e.keypath);
                    updating(this);
                },
                statusChange: function(e)
                {
                     products.setStatus(e.index.i,$(e.node).val());
                     updating(this);
                },
                change: function(e)
                {
                    products.save();
                }
            });
        }
    });

    ractive=new OrderRactive(
    {
      el: "#items-products",
      template: "#template-products",
      data: {
          products: products.items,
          count: products.count,
          totalPrice: products.totalPrice,
          delivery: products.userDeliveryPrice,
          priceFormat: function(price)
          {
            return number_format(price, 0, "."," ");
          },
      },
    });';

$cs->registerPackage('ractivejs')->registerPackage('sweet')->registerScript("edit_order",$edit_order)->registerScript("js_products",$js_products);

?>

    <!-- Modal -->
    <div class="modal fade" id="modalAddProducts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php
        $cs->registerCss('modal-autocomplit','
            .ui-front
            {
                z-index: 1050;
            }
        ');
        ?>
        <div class="modal-dialog" style="width:940px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Добавление товара</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $this->widget('application.widgets.AutoCompleteWidget',array(
                        'name'=>'term',
                        'value'=>'',
                        'source'=>$this->createUrl('catalog/search'),
                        'options'=>array(
                            'minLength'=>'3', // min chars to start search
                            'select'=>'js:function(event, ui) {
                            tempProducts.addProduct(new Product("",ui.item.id,ui.item.title,0,1,ui.item.price,1,1,ui.item.src));
                     }'
                        ),
                        'methodChain'=>'.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                            var words=this.term.split(" ");
                            var length=words.length;
                            for (var i=0;i<words.length;i++)
                            {
                                if (words[i]!="")
                                {
                                    item.label=item.label.replace(new RegExp("("+words[i]+")","gi"),"<strong>$1</strong>");
                                }
                            }
                       return $( "<li>" )
                           .data( "item.autocomplete", item )
                           .append( "<div class=\"row\"><div class=\"col-xs-4\"><img src=\"/"+item.src+"\"></div><div class=\"col-xs-8\">" + item.label +  "</div></div>")
                           .appendTo( ul );
                     }',
                        'htmlOptions'=>array(
                            'id'=>'searchstring',
                            'rel'=>'url',
                            'placeholder'=>'поиск',
                            'class'=>'search-input'
                        ),
                    ));
                    ?>
                    <div id="temp-add-products">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="tempToProduct">Добавить</button>
                    <a href="javascript:void(0);" id="cancelAddProducts">Отмена</a>
                </div>
            </div>
        </div>
    </div>

    <script id="template-products-temp" type="ractive/text">
    <div class="items-list">
        <div class="row header">
            <div class="c-num">№</div>
            <div class="c-image">Вид</div>
            <div class="c-title">Наименование товара</div>
            <div class="c-price">Цена / скидка</div>
            <div class="c-count">Количество</div>
            <div class="c-sum">Сумма</div>
            <div class="c-status"></div>
        </div>
        {{#products:i}}
        <div class="row order">
            <div class="c-num"><div class="cell">№</div></div>
            <div class="c-image"><div class="cell"><img src="/{{image}}" /></div></div>
            <div class="c-title"><div class="cell">{{title}}</div></div>
            <div class="c-price"><div class="cell">{{priceFormat(price)}}</div></div>
            <div class="c-count">
                {{countEdit}}
            </div>
            <div class="c-sum"><div class="cell">{{priceFormat(totalPrice)}}</div></div>
            <div class="c-status">
                <a href="javascript:void(0);" data-index="{{i}}" on-click="removeItem"><i class="glyphicon glyphicon-trash"></i></a>
            </div>
        </div>
        {{/products}}
    </div>
</script>

<?php

$temp_add_products='

    tempProducts=new OrderProducts;

    tempRactive=new Ractive(
    {
      el: "#temp-add-products",
      template: "#template-products-temp",
      data: {
          products: tempProducts.items,
          count: tempProducts.count,
          totalPrice: tempProducts.totalPrice,
          priceFormat: function(price)
          {
            return number_format(price, 0, "."," ");
          },
      },
    });

    tempRactive.on("removeItem",function(e)
    {
        var self=this;
        swal({
          title: "Удалить товар?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Да удалить!",
          cancelButtonText: "Нет",
          closeOnConfirm: false
        },
        function(){
          tempProducts.removeItem(e.index.i);
          swal("Удален!", "Товар удален", "success");
          self.update("products");
        });
    });

    $("#tempToProduct").on("click",function()
    {
       $.each(tempProducts.items,function(index)
       {
            products.addProduct(this);
       });

       ractive.set("totalPrice",products.totalPrice);
       ractive.update("totalPrice");
       ractive.set("count",products.count);
       ractive.update("count");
       ractive.set("delivery",products.userDeliveryPrice);
       ractive.update("delivery");

       tempProducts.clean();
       tempRactive.set("products",tempProducts.items);
       tempRactive.update("products");
       $("#modalAddProducts").modal("hide");
       $("#searchstring").val("");
    });

    $("#cancelAddProducts").on("click",function()
    {
       tempProducts.clean();
       tempRactive.set("products",tempProducts.items);
       $("#modalAddProducts").modal("hide");
       $("#searchstring").val("");
    });
    ';

$cs->registerPackage('ractivejs')->registerPackage('sweet')->registerScript("temp_add_products",$temp_add_products);
