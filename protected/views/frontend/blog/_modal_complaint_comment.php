<!-- Modal жалоба на комментарий -->
<div class="modal fade" id="message_comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Отправить жалобу на комментарий</h4>
            </div>
            <?php $form=$this->beginWidget('BsActiveForm', array(
                'htmlOptions'=>array(
                    'id'=>'complaint-comment-form',
                    'role'=>'form',
                ),
                'action'=>$this->createUrl('blog/complaint'),
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
            )); ?>
            <div class="modal-body">
                <?php echo $form->textArea($complaint, 'text', array('placeholder'=>'', 'rows'=>6, 'class'=>'form-control border')); ?>
                <?php echo $form->error($complaint, 'text'); ?>

                <?php echo BsHtml::hiddenField('post_id', ''); ?>
                <?php echo BsHtml::hiddenField('module_id', Comments::MODULE_ID); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <?php echo BsHtml::ajaxSubmitButton(Yii::t('app','Send complaint'), $this->createUrl('blog/complaint'), array(
                        'dataType'=>'json',
                        'type'=>'POST',
                        'success'=>'function(data)
                                    {
                                      if(data.status=="success")
                                      {
                                        $("#message_comment").modal("hide");
                                        $("#complaint-comment-form")[0].reset();

                                        var value = $("#message_comment input[type=hidden]#post_id").val();

                                        $(".comment .links a#"+value).parents(".comment:first").find(".exclamation span").addClass("active");

                                        $(".one-comment#"+value).find(".exclamation").addClass("isset");
                                        $(".one-comment#"+value).find(".exclamation span:last").text(parseInt($(".one-comment#"+value).find(".exclamation span").text())+1);

                                        $("#modal_complaint").modal("show");
                                      }
                                      else
                                      {
                                        $.each(data, function(key, val)
                                        {
                                          $("#complaint-comment-form").find("#"+key+"_em_").text(val).show();
                                        });
                                      }
                                    }',
                    ),
                    array('class'=>'btn btn-primary')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>