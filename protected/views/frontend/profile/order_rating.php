<?php
/* @var $this ProfileController */
/* @var $model OrdersRating */
/* @var $form CActiveForm */
?>

<?php
$model=$order->orderRating;

$cs=Yii::app()->getClientScript();
$cs->registerPackage('raty');
$cs->registerScript('raty-rating',
    '
        $(".raty_speed").raty({ readOnly: true, score: "'.$model->speed.'"});
        $(".raty_delivery").raty({ readOnly: true, score: "'.$model->delivery.'"});
        $(".raty_civility").raty({ readOnly: true, score: "'.$model->civility.'"});
        $(".raty_quality").raty({ readOnly: true, score: "'.$model->quality.'"});
    '
);
?>
<div class="main-title">Оценка заказа #<?php echo $order->id; ?>
    <div class="back pull-right">
        <a href="<?php echo $this->createUrl('order',array('id'=>$order->id)); ?>"><span class="fa fa-arrow-left"></span> <span class="link">Назад к заказу</span></a>
    </div>
</div>
<div class="form">
    <div class="form-group row">
        <div class="col-xs-3 label-block"> </div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_speed" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $model->getAttributeLabel('speed'); ?></div></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group row">
        <div class="col-xs-3 label-block"></div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_delivery" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $model->getAttributeLabel('delivery'); ?></div></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group row">
        <div class="col-xs-3 label-block"> </div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_civility" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $model->getAttributeLabel('civility'); ?></div></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group row">
        <div class="col-xs-3 label-block"> </div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_quality" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $model->getAttributeLabel('quality'); ?></div></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group row">
        <div class="col-xs-3 label-block"> <?php echo $model->getAttributeLabel('message'); ?>     </div>
        <div class="col-xs-5"> <?php echo CHtml::encode($model->message); ?></div>
        <div class="col-xs-4"></div>
    </div>

</div><!-- form -->