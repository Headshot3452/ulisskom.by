<div class="form">
<?php
$form=$this->beginWidget('BsActiveForm', array(
    'id'=>'gallery-products-product-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of BsActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
));
?>

    <div class="row" id="Description">
        <?php echo $this->renderPartial('_form_image',array('model'=>$model,'form'=>$form),true,false); ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save')); ?>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->