<div class="row cart-delivery">
    <?php
    $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'stateful'=>true,
        'htmlOptions'=>array(
            'class'=>"form-horizontal center",
        ),
    ));
    ?>
    <div class="col-xs-6">
        <div class="title">Личные данные</div>
        <div class="form-group">
            <div class="col-xs-4">
                <?php echo $form->labelEx($model,'fio',array('control-label')); ?>
            </div>
            <div class="col-xs-8">
                <?php echo $form->textField($model,'fio',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'fio',array('class'=>'errorMessage')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <?php echo $form->labelEx($model,'phone',array('control-label')); ?>
            </div>
            <div class="col-xs-8">
                <?php echo $form->textField($model,'phone',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'phone',array('class'=>'errorMessage')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <?php echo $form->labelEx($model,'address',array('control-label')); ?>
            </div>
            <div class="col-xs-8">
                <?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'address',array('class'=>'errorMessage')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <?php echo $form->labelEx($model,'comment',array('control-label')); ?>
            </div>
            <div class="col-xs-8">
                <?php echo $form->textarea($model,'comment',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'comment',array('class'=>'errorMessage')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="title"><?php echo $form->labelEx($model,'type_delivery',array('control-label')); ?></div>
        <div class="form-group">
            <div class="col-xs-8">
                <?php echo $form->radioButtonList($model,'type_delivery',Orders::getTypeDelivery(),array('class'=>'')); ?>
                <?php echo $form->error($model,'type_delivery',array('class'=>'errorMessage')); ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <div class="col-xs-4 col-xs-offset-4">
            <?php
            echo BsHtml::submitButton('Далее',
                array('value'=>$model->step,'name'=>'step','class'=>'btn btn-danger pull-right')
            );
            echo BsHtml::submitButton('Назад',
                array('color' => BsHtml::BUTTON_COLOR_LINK,'value'=>$model->step,'name'=>'back','class'=>'btn btn-link  pull-right')
            );
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>