<div class="row profileblog">
    <h2 class="col-md-12">Настройка уведомлений</h2>

    <div class="clearfix"></div>

    <div class="col-md-6 notifications">
        <?php $form=$this->beginWidget('BsActiveForm', array(
            'id'=>'change-user-setting',
            'enableAjaxValidation'=>false,
        )); ?>
        <div class="">
            <?php echo $form->checkBox($model,'send_complaint', array('id'=>'notif_0')); ?>
            <label for="notif_0">Принимать уведомления о жалобах</label>
        </div>
        <div class="">
            <?php echo $form->checkBox($model,'send_block', array('id'=>'notif_1')); ?>
            <label for="notif_1">Принимать уведомления о блокировках</label>
        </div>
            <div class="row col-md-12 submit-buttons">
                <?php
                echo BsHtml::submitButton(Yii::t('app','Save'),
                    array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'class' => ''));
                echo CHtml::link(Yii::t('app','Cancel'), array('profileblog/index'), array('class' => 'cancel_link'));
                ?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>