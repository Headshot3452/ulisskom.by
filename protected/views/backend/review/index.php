<div class="form">

    <?php
    $form = $this->beginWidget('BsActiveForm', array(
        'id' => 'rewiew-settins-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
        'action' => $this->createUrl('update_params'),
    ));
    ?>

    <?php
    echo $this->renderPartial('_form_settings', array('model' => $model, 'form' => $form, 'data' => $data));
    ?>
    <?php $this->endWidget();
        if($edit!=null) $this->renderPartial('_update_category_modal',array('edit'=>$edit,'new'=>$new));
    ?>
</div><!-- form -->