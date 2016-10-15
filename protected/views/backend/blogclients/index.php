<div class="form">

    <?php
    $setting = Settings::model()->find();

    $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'catalog-products-product-form',
        'enableAjaxValidation'=>false,
        'action' => $this->createUrl('update_params'),
    ));
    ?>

    <div class="form-group load-file blog-func">
        <div class="col-xs-12 title">
            Функции блога
        </div>
        <?php foreach($data as $key => $value) { ?>
            <div class="col-xs-12 func-load-file">
                <label class="checkbox-active <?php echo ($value->status!=0)?'active':'' ?>"></label>
                <input type="hidden" name="setting[<?php echo $value->id; ?>]" value="<?php echo ($value->status!=0)?'1':'0' ?>">
                <span><?php echo $value->name; ?></span>
            </div>
        <?php } ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php echo $this->renderPartial('_update_modal', array('modal'=>$modal)); ?>

<?php
$checkbox_params='
    $("label.checkbox-active").click(function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active");
                $(this).next().attr("value",0);
            }
            else
            {
                $(this).addClass("active");
                $(this).next().attr("value",1);
            }
        });
';

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('checkbox_params',$checkbox_params);

?>