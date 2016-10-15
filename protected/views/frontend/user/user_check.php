<?php
    /* @var $this UsersController */
    /* @var $model Users */
    /* @var $form BsActiveForm */
?>

<div class="form">

<?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm',
        array(
            'id' => 'users-login-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'center'),
        )
    );
?>
    <div class="form-group text-center title">
        <?php echo Yii::t('app', 'Password recovery') ;?>
    </div>

	<div class="row control-group form-group">
        <div class="col-xs-12">
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email', array('class' => 'errorMessage')); ?>
        </div>
	</div>

<?php
    if(CCaptcha::checkRequirements() && Yii::app()->user->issetCaptcha())
    {
        echo CHtml::activeLabelEx($model, 'captcha', array('class' => 'control-label'));
        $this->widget('CCaptcha');
        echo CHtml::activeTextField($model, 'captcha');
    }
?>

	<div class="row buttons control-group">
        <div class="col-xs-12">
            <?php echo BsHtml::submitButton(Yii::t('app', 'Reset'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'style' => 'width: 119px; padding: 4px 0;')); ?>
            <?php echo BsHtml::link(Yii::t('app', 'Enter'), $this->createUrl('login'), array('class' => 'back')); ?>
        </div>
	</div>

    <?php $this->endWidget(); ?>

</div>