<?php
    $image = $data->getOneFile('small');
    if(!$image)
    {
        $image = Yii::app()->params['noimage'];
    }
?>

<div class="small catalog" id="products-list">
    <div class="one_item" id="<?php echo $data->id;?>">
        <div class="row">
            <div class="img-cont">
                <a href="<?php echo $this->createUrl("index") ;?>">
                    <img width="50" height="50" src="/<?php echo $image;?>" alt="" title="" />
                </a>
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
                if($this->currency_ico["format"] == 1)
                {
                    $format = 2;
                    $sale_price = $data->getSalePrice($data->price, $data->sale_info, 2);
                }
                else
                {
                    $sale_price = $data->getSalePrice($data->price, $data->sale_info, 0);
                    $sale_price = Yii::app()->format->formatNumber(round(str_replace(" ", "", $sale_price)));
                    $data->price = round($data->price);
                    $format = 0;
                }

                if(isset($sale_price) && !empty($sale_price))
                {
?>
                    <div class="price">
                        <?php echo $sale_price; ?>
                        <span> <?php echo $this->currency_ico_view ;?> </span>
                    </div>
                    <div class="price_sale">
<?php
                        echo number_format(is_numeric($data->price) ? $data->price : 0, $format, '.', ' ');
?>
                        <span> <?php echo $this->currency_ico_view ;?> </span>
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
            <div class="col-xs-2">
                <a href="<?php echo $this->createUrl('active', array('id' => $data->id))?>" class="btn btn-small btn-active hint--bottom hint--rounded" data-hint="<?php echo Yii::t('app', 'Change status') ;?>"><span class="icon-admin-power-switch-<?php echo ($data->status==CatalogProducts::STATUS_OK ? 'green' : 'red'); ?>"></span></a>
                <a href="<?php echo $this->createUrl('delete_product', array('id' => $data->id )) ?>" class="btn btn-small btn-trash hint--bottom hint--rounded" data-hint="<?php echo Yii::t('app', 'Remove product') ;?>"><span class="fa fa-trash-o"></span></a>
            </div>
        </div>
    </div>
</div>