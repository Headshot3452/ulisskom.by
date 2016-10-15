<?php
    $image = $data->getOneFile('small');
    if(!$image)
    {
        $image = Yii::app()->params['noimage'];
    }
    $sale_price = $data->getSalePrice($data->price, $data->sale_info);
?>

<li class="one_item" id="<?php echo $data->id ;?>">
    <div class="row">
        <div class="col-xs-1 status_line">
            <div class="status <?php echo ($data->status == 1) ? 'active' : 'not_active'; ?>">
                <?php echo BsHtml::checkBox('checkbox['.$data->id.']', false, array('class' => 'checkbox group')); ?>
                <?php echo BsHtml::label('', 'checkbox_'.$data->id,false, array('class' => 'checkbox')); ?>
            </div>
        </div>
        <div class="col-xs-1">
            <?php echo BsHtml::link('<img style="margin-top:12px;" width="50" height="50" src="/'.$image.'" alt="" title="" />', $this->createUrl('update_product').'?id='.$data->id); ?>
        </div>
        <div class="col-xs-6 name">
<?php
            echo
            BsHtml::link($data->title,$this->createUrl('update_product').'?id='.$data->id);

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
            }
            else
            {
                $sale_price = Yii::app()->format->formatNumber(round(str_replace(" ", "", $sale_price)));
                $data->price = round($data->price);
                $format = 0;
            }

            if(!empty($sale_price))
            {
?>
                <div class="price">
                    <?php echo $sale_price ;?>
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
    </div>
</li>