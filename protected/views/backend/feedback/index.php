<div class="form">

    <?php
    $setting = Settings::model()->find();

    $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'catalog-products-product-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
        'action' => $this->createUrl('update_params'),
    ));
    ?>
    <?php if(isset($data)): ?>
    <div class="tab-content">
        <?php echo $this->renderPartial('_form_settings',array('model'=>$model,'form'=>$form, 'data'=>$data, 'id'=>$id)); ?>
    </div>
    <?php endif; ?>

    <div class="form-group load-file">
        <div class="col-xs-12 title">
            Функция загрузки файлов
        </div>
        <div class="col-xs-12 func-load-file">
            <label class="checkbox-active <?php echo ($setting->load_file_feedback!=0)?'active':'' ?>"></label>
            <input type="hidden" name="load_file" value="<?php echo ($setting->load_file_feedback!=0)?'1':'0' ?>">
            <span>Включить функцию загрузки файлов</span>
        </div>
    </div>

    <div class="form-group load-file">
        <div class="col-xs-12 title">
            Темы вопросов
        </div>
        <div class="col-xs-12 func-load-file">
            <label class="checkbox-active <?php echo ($setting->thema_question_feedback!=0)?'active':'' ?>"></label>
            <input type="hidden" name="thema_question" value="<?php echo ($setting->thema_question_feedback!=0)?'1':'0' ?>">
            <span>Отображать темы вопросов</span>
        </div>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

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