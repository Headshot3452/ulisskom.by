<div class="col-xs-12">
    <div class="title related_title"><?php echo Yii::t('app', 'Products releated products'); ?></div>
    <a href="#modal_releated" role="button" data-toggle="modal" class="btn btn-primary btn-action releated_products">
        + Добавить из каталога
    </a>
</div>

<div id="products-list" class="col-xs-12">
    <ul>
<?php
        foreach ($products_releated as $data)
        {
            $image = $data->getOneFile('small');
            if(!$image)
            {
                $image = Yii::app()->params['noimage'];
            }
            $sale_price = $data->getSalePrice($data->price, $data->sale_info);

            if($this->currency_ico["format"] == 1)
            {
                $format = 2;
            }
            else
            {
                $sale_price = Yii::app()->format->formatNumber(round(str_replace(" ", "", $sale_price)));
                $data->price = round($data->price);
                $format = 0;
            }
?>
            <li class="one_item col-xs-12" id="<?php echo $data->productsReleatedsId[0]->id ;?>">
                <div class="row">
                    <div class="col-xs-1">
                        <img width="50" height="50" src="/<?php echo $image ;?>" alt="" title="" />
                    </div>
                    <div class="col-xs-5 name">
                        <?php echo BsHtml::link($data->title, $this->createUrl('update_product').'?id='.$data->id); ?>
<?php
                        if(!empty($data->article))
                        {
?>
                            <div class="article">
                                <span>Арт.</span><?php echo $data->article; ?>
                            </div>
<?php
                        }
?>
                    </div>

                    <div class="col-xs-3 text-right">
<?php
                        if(!empty($sale_price))
                        {
?>
                            <div class="price">
                                <?php echo $sale_price; ?>
                                <span> <?php echo $this->currency_ico["currency_name"] ;?> </span>
                            </div>
                            <div class="price_sale">
                                <?php echo number_format($data->price, $format, '.', ' '); ?>
                                <span> <?php echo $this->currency_ico["currency_name"] ;?> </span>
                            </div>
<?php
                        }
                        else
                        {
?>
                            <div class="price">
                                <?php echo number_format($data->price, $format, '.', ' '); ?>
                                <span> <?php echo $this->currency_ico["currency_name"] ;?> </span>
                            </div>
<?php
                        }
?>
                    </div>
                    <div class="col-xs-1 deals">
                        <?php if ($data->new == 1) echo '<i class="fa fa-bookmark fa-rotate-270 new"></i>'; ?>
                        <?php if ($data->sale == 1) echo '<i class="fa fa-bookmark fa-rotate-270 sale_product"></i>'; ?>
                        <?php if ($data->popular == 1) echo '<i class="fa fa-bookmark fa-rotate-270 popular"></i>'; ?>
                    </div>
                    <div class="col-xs-2 text-center no-right">
                        <span class="icon-admin-delete" id="<?php echo $data->productsReleatedsId[0]->id ;?>"></span>
                        <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
                    </div>
                </div>
            </li>
<?php
        }
?>
    </ul>
</div>

<?php
    $cs = Yii::app()->getClientScript();

    $related_sortable = '
        $("#products-list ul").nestedSortable(
        {
            items: "li",
            listType: "ul",
            tabSize : 15,
            maxLevels: 0,

            update:function( event, ui )
            {
                $.ajax(
                {
                    type: "POST",
                    url: "'.$this->createUrl("releated_sort").'",
                    data:
                    {
                        id: $(ui.item).attr("id"),
                        index: $(ui.item).index(),
                    },
                    success: function(data)
                    {
                        console.log(data);
                    }
                });
            }
        });
    ';

    $cs->registerScript("related_sortable", $related_sortable);
?>

<script>

$(function()
{
    $("#Products_releated .icon-admin-delete").on('click', function()
    {
        var id = $(this).attr('id');

        if(confirm('<?php echo Yii::t('app', 'Are you sure you want to delete the related product?') ;?>'))
        {
            $.ajax(
            {
                type: "POST",
                data: {id:id},
                url: '/admin/catalog/products_releated_delete/',
                success:function(data)
                {
                    if(data != '')
                    {
                        $("#products-list li").each(function()
                        {
                            if($(this).attr('id') == data )
                            {
                                $(this).remove();
                            }
                        });
                    }
                }
            })
        }
    })
})

</script>