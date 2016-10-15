<div class="text">
<div class="form" xmlns="http://www.w3.org/1999/html">

    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'stateful'=>true,
        'htmlOptions'=>array(
            'class'=>"form-horizontal center",
        ),
    ));

    ?>

    <?php
    $show = false;
    if($model_cart->getErrors() || $model_delivery->getErrors())
    {
        $show = true;
    }


    ?>

    <?php echo $model_cart->cart; ?>

    <?php echo $form->hiddenField($model_cart,'products'); ?>

<?php if(!$show){ ?>
    <div class="row buttons">
        <?php echo BsHtml::button('Оформить заказ',
            array('color'=>BsHtml::BUTTON_COLOR_DANGER,'class'=>'pull-right','data-toggle'=>"collapse", 'href'=>"#cart_info")
        ); ?>
    </div>

    <script>
        $(document).ready(function(){
            $('#cart_info').on('show.bs.collapse', function () {
                $('button[data-toggle=collapse]').hide();
            });

            $('.delivery input').change(function(){

                if($(this).val() == <?php echo Orders::ORDER_DELIVERY_TO_ADDRESS; ?>)
                {
                    $('#address').show();
                }
                else
                {
                    $('#address').hide();
                }

            });
        });

    </script>
<?php } ?>

    <div id="cart_info"  class="collapse <?php echo $show? 'in' : '' ?>">

        <div class="col-xs-5">
            <div class="title">Доставка</div>

            <div class="form-group">
                <div class="col-xs-8 delivery">
                    <?php echo $form->radioButtonList($model_delivery,'type_delivery',Orders::getTypeDelivery(),array('class'=>'')); ?>
                    <?php echo $form->error($model_delivery,'type_delivery',array('class'=>'errorMessage')); ?>
                </div>
            </div>

            <div id="address" <?php echo $model_delivery->type_delivery == Orders::ORDER_DELIVERY_NOT_ADDRESS? 'style="display: none;"' : '' ?>>
                <div class="form-group">
                    <div class="col-xs-12">
                    <?php echo $form->labelEx($model_delivery,'city',array('control-label')); ?>
                    <?php echo $form->textField($model_delivery,'city',array('class'=>'form-control')); ?>
                    <?php echo $form->error($model_delivery,'city',array('class'=>'errorMessage')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                    <?php echo $form->labelEx($model_delivery,'address',array('control-label')); ?>
                    <?php echo $form->textField($model_delivery,'address',array('class'=>'form-control')); ?>
                    <?php echo $form->error($model_delivery,'address',array('class'=>'errorMessage')); ?>
                    </div>
                </div>
            </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?php echo $form->labelEx($model_delivery,'comment',array('control-label')); ?>
                        <?php echo $form->textArea($model_delivery,'comment',array('class'=>'form-control')); ?>
                        <?php echo $form->error($model_delivery,'comment',array('class'=>'errorMessage')); ?>
                    </div>
                </div>


        </div>

        <div class="col-xs-6 col-xs-offset-1">
            <div class="title">Оплата</div>
            <div class="text payment">
                [[w:BlockWidget|block_id=3]]
            </div>

            <div class="title">Контактная информация</div>

            <div class="form-group">
                <div class="col-xs-12">
                    <?php echo $form->labelEx($model_delivery,'fio',array('control-label')); ?>
                    <?php echo $form->textField($model_delivery,'fio',array('class'=>'form-control')); ?>
                    <?php echo $form->error($model_delivery,'fio',array('class'=>'errorMessage')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-6">

                        <?php echo $form->labelEx($model_delivery,'phone',array('control-label')); ?>
                        <?php echo $form->textField($model_delivery,'phone',array('class'=>'form-control')); ?>
                        <?php echo $form->error($model_delivery,'phone',array('class'=>'errorMessage')); ?>
                </div>

                <div class="col-xs-6">
                        <?php echo $form->labelEx($model_delivery,'email',array('control-label')); ?>
                        <?php echo $form->textField($model_delivery,'email',array('class'=>'form-control')); ?>
                        <?php echo $form->error($model_delivery,'email',array('class'=>'errorMessage')); ?>
                </div>
            </div>

        </div>

        <div class="row col-xs-12 buttons">
            <?php echo BsHtml::submitButton('Оформить заказ',
                array('name'=>'step','value'=>'finish','color'=>BsHtml::BUTTON_COLOR_DANGER,'class'=>'pull-right')
            ); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
</div>