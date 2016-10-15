<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form BsActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id'=>'users-update-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
    )); ?>




    <div class="row buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->