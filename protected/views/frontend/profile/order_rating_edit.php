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
        $(".raty_speed").raty({ scoreName: "OrdersRating[speed]", score: "'.$model->speed.'"});
        $(".raty_delivery").raty({ scoreName: "OrdersRating[delivery]", score: "'.$model->delivery.'"});
        $(".raty_civility").raty({ scoreName: "OrdersRating[civility]", score: "'.$model->civility.'"});
        $(".raty_quality").raty({ scoreName: "OrdersRating[quality]", score: "'.$model->quality.'"});
    '
);
?>
<div class="main-title">Оценка заказа #<?php echo $order->id; ?>
    <div class="back pull-right">
        <a href="<?php echo $this->createUrl('order',array('id'=>$order->id)); ?>"><span class="fa fa-arrow-left"></span> <span class="link">Назад к заказу</span></a>
    </div>
</div>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'order-rating-form',
        'htmlOptions'=>array(
            'class'=>"form-horizontal",
        ),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
    )); ?>

    <div class="form-group">
        <div class="col-xs-3 label-block"> </div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_speed" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $form->labelEx($model,'speed'); ?></div></div>
            <div class="clearfix"><?php echo $form->error($model,'speed'); ?></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group">
        <div class="col-xs-3 label-block"></div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_delivery" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $form->labelEx($model,'delivery'); ?></div></div>
            <div class="clearfix"><?php echo $form->error($model,'delivery'); ?></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group">
        <div class="col-xs-3 label-block"> </div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_civility" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $form->labelEx($model,'civility'); ?></div></div>
            <div class="clearfix"><?php echo $form->error($model,'civility'); ?></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group">
        <div class="col-xs-3 label-block"> </div>
        <div class="col-xs-5">
            <div class="clearfix"><div class="raty_quality" style="float:left;"></div> <div style="margin-left:15px; float: left;"><?php echo $form->labelEx($model,'quality'); ?></div></div>
            <div class="clearfix"><?php echo $form->error($model,'quality'); ?></div>
        </div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group">
        <div class="col-xs-3 label-block"> <?php echo $form->labelEx($model,'message'); ?>     </div>
        <div class="col-xs-5"> <?php echo $form->textArea($model,'message',array('class'=>"form-control")); ?>  <?php echo $form->error($model,'message'); ?></div>
        <div class="col-xs-4"></div>
    </div>

    <div class="form-group">
        <div class="col-xs-3">    </div>
        <div class="col-xs-5">
            <?php echo BsHtml::submitButton(Yii::t('app','Save'),
                array('color' => BsHtml::BUTTON_COLOR_PRIMARY)
            ); ?>
        </div>
        <div class="col-xs-4"> </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->