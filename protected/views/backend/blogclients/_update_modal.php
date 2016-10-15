<?php $category_id = (isset($_GET['category_id']))?$_GET['category_id']:''; ?>

<div class="modal fade modal-create-blog" id="update_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title  text-center" id="myModalLabel">Добавить категорию</h4>
            </div>
            <div class="modal-body no-padding">
                <?php
                $form = $this->beginWidget('BsActiveForm', array(
                    'id' => 'blog-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'action' => $this->createUrl('update_category').'?parent='.$category_id,
                ));?>
                <div class="form-group">
                    <?php echo $form->textField($modal, 'title' , array('placeholder'=>'')); ?>
                    <?php echo $form->error($modal, 'title'); ?>
                </div>
                <input type="hidden" name="change" value="0">
                <div class="form-group">
                    <?php
                        echo BsHtml::ajaxSubmitButton(Yii::t('app','Save'),$this->createUrl('update_category').'?parent='.$category_id,array(
                            'dataType'=>'json',
                            'type'=>'POST',
                            'beforeSend'=>'function()
                            {
                                $("#blog-form").find("button").attr("disabled","disabled");
                            }',
                                'success'=>'function(data)
                            {
                              var form=$("#blog-form");
                              if(data.status=="success")
                              {
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
                                $("#blog-form").find("button").removeAttr("disabled");
                            }',
                            ),
                            array(
                                'class'=>'btn-success'
                            )
                        )
                    ?>
                    <a data-dismiss="modal">Отмена</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$update_category='
    $(".left-content .buttons .dropdown-menu a:first").on("click", function(){
        $(".modal-create-blog").find("input[type=hidden]").val(0);
        $(".modal-create-blog").find("input[type=text]").val("");
    });
    $("#main-left-tree-menu > li:first").on("click", function(){
        $(".modal-create-blog").find("input[type=hidden]").val(3);
        $(".modal-create-blog").find("input[type=text]").val("");
    });


    $(".left-content .buttons .dropdown-menu a:last").on("click", function(){
        $(".modal-create-blog").find("input[type=hidden]").val(1);
    });
';

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('update_category',$update_category);

?>