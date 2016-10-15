<?php
    /* @var $this AskanswerController */
    /* @var $model AskAnswerGroup */
    /* @var $form BsActiveForm */
?>

<div class="form">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'askanswergroup_form-form',
            'enableAjaxValidation' => false,
        )
    );

    echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app', 'Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div>