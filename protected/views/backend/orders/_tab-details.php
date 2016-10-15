<table class="table table-hover order-products">
    <thead>
        <tr class="color-gray">
            <th class="text-left number">№</th>
            <th class="text-center">Вид</th>
            <th>Наименование товара</th>
            <th>Цена / Скидка</th>
            <th class="text-center">Кол-во / Вес</th>
            <th class="text-right">Сумма</th>
            <th class="text-center">Статус</th>
        </tr>
    </thead>
    <tbody>
<?php
        $currency = SettingsCurrencyList::getCurrencyBasic();

        foreach($products as $key => $value)
        {
            $discount = '';
            $item = CatalogProducts::model()->active()->findByPk($value->product_id);

            $image = $item->getOneFile('small');
            $parent = CatalogTree::model()->active()->findByPk($item->parent_id);

            $link = $this->getUrlById(Yii::app()->params['catalog_page']).'/'.$item->getUrlForItem($parent->root);

            $unit = $item->getUnitType() ? $item->getUnitType() : 'шт';

            $count_edit = $value->count_edit;

            if($value->discount)
            {
                $discount = '<span class="color-red">-'.number_format($value->price - $value->discount, 2, '.', ' ').'</span>';
            }

            if($count_edit > 0)
            {
                $count_view = "(+".$count_edit.")";
                $color = 'color-green';
            }
            elseif($count_edit < 0)
            {
                $count_view = "(".$count_edit.")";
                $color = 'color-red';
            }
            else
            {
                $count_view = '';
                $color = '';
            }

            if(!$image)
            {
                $image = '/images/noavatar.png';
            }

            $sum = $value->discount ? $value->getItemDiscount() : $value->getItemPrice();

            $yes = ($value->count + $value->count_edit) ? 'selected' : '';
            $no = ($value->count + $value->count_edit) ? '' : 'selected';

            $color_drop = $yes ? 'color-green' : 'color-red';

            echo
                '<tr class="one-order-product">
                    <td class="text-left number">'.$key.'</td>
                    <td class="text-center">
                        <a href="/'.$link.'" target="_blank">
                            <img src="/'.$image.'">
                        </a>
                    </td>
                    <td class="col-md-4 cursor-pointer">
                        <div class="product-title">
                            <a href="/'.$link.'" target="_blank">
                                '.$value->title.'
                            </a>
                        </div>
                        <span class="color-gray id-product"># '.$item->id.'</span>
                    </td>
                    <td class="baseline">
                        <span>'.number_format($value->price, 2, '.', ' ').'</span> <span class="color-gray"><span class="currency text-uppercase">'.key($currency).'</span>/<span
                                class="unity">'.$unit.'</span></span><br/>
                        '.$discount.'
                    </td>
                    <td class="text-center count baseline">
                        <span class="fa fa-minus cursor-pointer color-gray"></span>
                        <span class="input text-center">'.$value->count.' <span class="'.$color.'">'.$count_view.'</span></span>
                        '.$form->hiddenField($value, "count_edit[$value->id]", array("class" => "hidden_count", "value" => $value->count_edit)).'
                        <span class="fa fa-plus cursor-pointer color-gray"></span>
                    </td>
                    <td class="text-right baseline">
                        <span class="color-primary">'.number_format($sum, 2, '.', ' ').'</span> <span class="color-gray text-uppercase">'.$this->currency_ico_view.'</span>
                    </td>
                    <td class="text-center status baseline">
                        '.CHtml::dropDownList("existence[$value->id]", '',
                            array(
                                'stock' => Yii::t('app', 'In stock'),
                                '-'.$value->count => Yii::t('app', 'Missing')
                            ),
                            array(
                                'options' => array(
                                    'stock' => array('class' => 'color-green', 'selected' => $yes),
                                    '-'.$value->count => array('class' => 'color-red', 'selected' => $no)
                                ),
                                'class' => $color_drop
                            )
                        ).'
                    </td>
                </tr>';
        }
?>
    </tbody>
</table>
<div>
    <a class="color-primary cursor-pointer add-product"  data-id="<?php echo $order->id ;?>" href="#modal_releated" role="button" data-toggle="modal"><span class="fa fa-plus"></span> Добавить товар-услугу</a>
</div>
<div class="">
    <div class="col-md-12 top-border no-padding">
        <table class="table table-hover result pull-right">
            <tr>
                <td class="color-gray text-right">Количество товаров-услуг:</td>
                <td class="text-right"><?php echo $order->count ;?> <span class="color-gray">шт.</span></td>
            </tr>
            <tr>
                <td class="color-gray text-right"><?php echo Yii::t('app', 'Sum') ;?>:</td>
                <td class="text-right"><?php echo $order->f_sum ;?> <span class="color-gray text-uppercase"><?php echo $this->currency_ico_view ;?></span></td>
            </tr>
            <tr>
                <td class="color-gray text-right">Доставка:</td>
                <td class="text-right">0 <span class="color-gray text-uppercase"> <?php echo $this->currency_ico_view ;?></span></td>
            </tr>
        </table>
    </div>
    <div class="col-md-12 top-border no-padding">
        <table class="table table-hover result pull-right">
            <tr>
                <td class="color-gray text-right">Итого:</td>
                <td class="text-right"><span class="color-primary"><?php echo $order->f_sum ;?> </span> <span
                    class="color-gray text-uppercase"><?php echo $this->currency_ico_view ;?></span></td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12 order-buttons text-right" data-order="<?php echo $order->id ;?>">
        <button class="btn btn-primary">Печатать</button>
        <button class="btn btn-success" data-status="3">Комплектовать</button>
        <a class="underline" href="" onclick="location.reload();">Отмена</a>
    </div>
</div>

<?php
    $this->renderPartial('_modal_add_products');
?>

<div class="form-group buttons">
    <?php echo BsHtml::submitButton(Yii::t('app', 'Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
    <span>Отмена</span>
</div>

<?php
    $cs = Yii::app()->getClientScript();
    $input = '
        $(document).ready(function()
        {
            $(".one-order-product .input span").each(function()
            {
                var text = $(this).text();

                if(text > 0)
                {
                    $(this).addClass("color-green");
                }
                if(text == 0)
                {
                    $(this).hide();
                }
            });

            $("body").on("click", ".one-order-product .fa-minus", function()
            {
                viewSubmitButton(this);
                var el = $(this).siblings(".hidden_count");

                template = /[0-9+]/;
                str = $(this).closest(".count").find(".input").text();

                var res = template.exec(str);

                if(parseInt(res) + parseInt(el.val()) > 0)
                {

                    el.val(parseInt(el.val()) - 1);

                    var el_show = $(this).closest(".count").find(".input span");

                    el_show.text("("+el.val()+")");

                    if(parseInt(el.val()) < 0)
                    {
                        el_show.show().addClass("color-red").removeClass("color-green");
                    }
                    else if(parseInt(el.val()) == 0)
                    {
                        el_show.hide();
                    }
                    else
                    {
                        el_show.text("(+"+el.val()+")");
                    }
                }
                if(parseInt(res) + parseInt(el.val()) == 0)
                {
                    $(this).closest(".one-order-product").find(".status :nth-child(2)").prop("selected", true);
                    $(this).closest(".one-order-product").find(".status select").removeClass("color-green").addClass("color-red");
                }
            });

            $("body").on("click", ".one-order-product .fa-plus", function()
            {
                viewSubmitButton(this);
                $("#orders-settings-form .form-group.buttons").show(500);

                var el = $(this).siblings(".hidden_count");
                el.val(parseInt(el.val()) + 1);

                var el_show = $(this).closest(".count").find(".input span");

                if(parseInt(el.val()) > 0)
                {
                    el_show.show().addClass("color-green").removeClass("color-red").text("(+"+el.val()+")");
                }
                else if(parseInt(el.val()) == 0)
                {
                    el_show.hide();
                }
                else
                {
                    el_show.text("("+el.val()+")");
                }

                $(this).closest(".one-order-product").find(".status :nth-child(1)").prop("selected", true);
                $(this).closest(".one-order-product").find(".status select").removeClass("color-red").addClass("color-green");
            });

            $("body").on("change", ".status select", function()
            {
                var opt = $(this).find("option:selected");
                $(this).attr("class", (opt.attr("class")));

                var n = parseInt(opt.val());

                var el = opt.closest(".one-order-product").find(".count")

                if((isNaN(n)))
                {
                    el.find(".input span").text("(0)").hide();
                    el.find(".hidden_count").val(0).attr("class", "color-green hidden_count");
                }
                else
                {
                    el.find(".input span").text("(" + n + ")").attr("class", "color-red hidden_count").show();
                    el.find(".hidden_count").val(n);
                }
            });
        });
    ';
    $cs->registerScript('input', $input);
