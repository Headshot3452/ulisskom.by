<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'phone-form',
            'htmlOptions' => array(
                'role' => 'form',
                'class' => 'form-horizontal',
            ),
            'enableAjaxValidation' => false,
            'action' => $this->createUrl('site/contacts'),
            'enableClientValidation' => true,
        )
    );
?>
    <div class="form-group">
            <?php echo $form->textField($model, 'name'); ?>
            <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-group">
<?php
        $this->widget('CMaskedTextField',
            array(
                'model' => $model,
                'attribute' => 'phone',
                'mask' => Yii::app()->params['phone']['mask'],
                'htmlOptions' => array(
                    'placeholder' => $model->getAttributeLabel('phone'),
                    'class' => 'form-control',
                )
            )
        );
?>
        <?php echo $form->error($model, 'phone') ;?>
    </div>
    <div class="form-group">
<?php
        echo CHtml::hiddenField('type', $model->scenario);
        echo BsHtml::ajaxSubmitButton(Yii::t('app', 'Send'),$this->createUrl('site/contacts'),
            array(
                'dataType' => 'json',
                'type' => 'POST',
                    'beforeSend' => 'function()
                    {
                        $("#phone-form").find("button").attr("disabled", "disabled");
                    }',
                    'success' => 'function(data)
                    {
                        var form = $("#phone-form");
                        if(data.status == "success")
                        {
                            alert("'.Yii::t('app', 'Thank you for your message. Manager will contact you.').'");
                            form[0].reset();
                        }
                        else
                        {
                            $.each(data, function(key, val)
                            {
                                form.find("#"+key+"_em_").text(val).show();
                            });
                        }
                    }',
                    'complete' => 'function()
                    {
                        $("#phone-form").find("button").removeAttr("disabled");
                    }',
                ),
                array(
                    'class' => 'btn-primary'
                )
            )
?>
    </div>
    <?php $this->endWidget(); ?>
