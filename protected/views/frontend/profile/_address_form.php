<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
?>
<div class="row">
    <h2 class="col-md-12"><?php echo $title; ?></h2>

    <div class="form col-md-6">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'address-index-form',
            'action' => $this->action->id != 'address',
            'htmlOptions' => array(
                'class' => "row",
            ),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // See class documentation of CActiveForm for details on this,
            // you need to use the performAjaxValidation()-method described there.
            'enableAjaxValidation' => false,
        )); ?>
<!--        <div class="col-md-12 form-group">-->
<!--            <div> --><?php //echo $form->errorSummary($model); ?><!--</div>-->
<!--        </div>-->

        <div class="col-md-12 form-group">
            <div> <?php echo $form->labelEx($model, 'country'); ?>     </div>
            <div> <?php echo $form->dropDownList($model, 'country', $this->getCountryFromAPI(), array('class' => "form-control", 'prompt' => 'Выберите ' . mb_strtolower($model->getAttributeLabel('country'), 'UTF-8'))); ?> </div>
            <div> <?php echo $form->error($model, 'country'); ?></div>
        </div>

        <div class="col-md-12 form-group">
            <div> <?php echo $form->labelEx($model, 'city_id'); ?>     </div>
            <div> <?php echo $form->dropDownList($model, 'city_id', CHtml::listData(City::model()->active()->findAll(), 'id', 'title'), array('class' => "form-control", 'prompt' => 'Выберите ' . mb_strtolower($model->getAttributeLabel('city_id'), 'UTF-8'))); ?> </div>
            <div> <?php echo $form->error($model, 'city_id'); ?></div>
        </div>

        <div class="col-md-12 form-group">
            <div> <?php echo $form->labelEx($model, 'index'); ?>     </div>
            <div> <?php echo $form->textField($model, 'index', array('class' => "form-control")); ?> </div>
            <div> <?php echo $form->error($model, 'index'); ?></div>
        </div>

        <div class="col-md-12 form-group">
            <div> <?php echo $form->labelEx($model, 'street'); ?>     </div>
            <div> <?php echo $form->textField($model, 'street', array('class' => "form-control")); ?> </div>
            <div> <?php echo $form->error($model, 'street'); ?></div>
        </div>

        <div class="form-group col-md-6">
            <div> <?php echo $form->labelEx($model, 'house'); ?>     </div>
            <div> <?php echo $form->textField($model, 'house', array('class' => "form-control")); ?> </div>
            <div> <?php echo $form->error($model, 'house'); ?></div>
        </div>

        <div class="form-group col-md-6">
            <div> <?php echo $form->labelEx($model, 'apartment'); ?>     </div>
            <div> <?php echo $form->textField($model, 'apartment', array('class' => "form-control")); ?> </div>
            <div> <?php echo $form->error($model, 'apartment'); ?></div>
        </div>

        <div class="col-md-12 form-group">
            <div> <?php echo $form->labelEx($model, 'user_name'); ?>     </div>
            <div> <?php echo $form->textField($model, 'user_name', array('class' => "form-control")); ?> </div>
            <div> <?php echo $form->error($model, 'user_name'); ?></div>
        </div>

        <div class="col-md-12 form-group">
            <div> <?php echo $form->labelEx($model, 'phone'); ?>     </div>
            <div> <?php echo $form->textField($model, 'phone', array('class' => "form-control")); ?> </div>
            <div> <?php echo $form->error($model, 'phone'); ?></div>
        </div>

        <div class="col-md-12 submit-buttons">
            <?php
            echo BsHtml::submitButton(Yii::t('app','Save'),
                array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'class' => ''));
            echo CHtml::link(Yii::t('app','Cancel'), array('profile/addresses'), array('class' => 'cancel_link'));
            ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
    <!-- form -->
</div>