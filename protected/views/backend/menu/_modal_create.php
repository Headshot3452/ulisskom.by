<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                'enableAjaxValidation' => false,
                'id'=>'menu-create-form',
                'enableClientValidation'=>true,
                'enableAjaxValidation'=>false,
            ));
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <div class="modal-title text-center">Добавление меню</div>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-xs-5 label-block">Введите название :*</div>
                    <div class="col-xs-6">
                        <?php echo $form->textField($model,'title'); ?>
                        <?php echo $form->error($model,'title'); ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer text-center">
                <?php
                    echo BsHtml::ajaxSubmitButton(Yii::t('app','Save'),$this->createUrl('create'),array(
                            'dataType'=>'json',
                            'type'=>'POST',
                            'beforeSend'=>'function()
                        {
                            $("#menu-create-form").find("button").attr("disabled","disabled");
                        }',
                            'success'=>'function(data)
                        {
                          var form=$("#menu-create-form");
                          if(data.status=="success")
                          {
                            form[0].reset();
                            window.location.reload();
                          }
                          else
                          {
                            $.each(data, function(key, val)
                            {
                              form.find("#"+key+"_em_").text(val).show();
                            });
                          }
                        }',
                        'complete'=>'function()
                        {
                            $("#menu-create-form").find("button").removeAttr("disabled");
                        }',
                        ),
                        array(
                            'class'=>'btn-primary'
                        )
                    )
                ?>
                <span class="btn-close" data-dismiss="modal">Отмена</span>
            </div>
            <?php
                $this->endWidget();
            ?>
        </div>
    </div>
</div>