<?php
    /* @var $order Orders */
?>
    <div class="row delivery-info">
<?php
//        $form = $this->beginWidget('BsActiveForm',
//            array(
//                'id' => 'order-delivery-form',
//                'enableAjaxValidation' => false,
//            )
//        );
?>
        <div class="col-md-6">
            <div class="block-title"><?php echo Yii::t('app', 'Customer information') ;?></div>
            <table class="table table-hover table_order_user">
                <tr>
                    <td class="color-gray"><?php echo Yii::t('app', 'Fullname') ;?>:</td>
                    <td><?php echo BsHtml::textField('order_user[fio]', $this->fio, array('readonly' => 'true')) ;?></td>
                    <td>
                        <button class="btn btn-default btn_pencil"><span class="fa fa-pencil"></span></button>
                    </td>
                </tr>
                <tr>
                    <td class="color-gray"><?php echo Yii::t('app', 'Phone') ;?>:</td>
                    <td><?php echo BsHtml::textField('order_user[phone]', $this->phone, array('readonly' => 'true')) ;?></td>
                    <td>
                        <button class="btn btn-default btn_pencil"><span class="fa fa-pencil"></span></button>
                    </td>
                </tr>
                <tr>
                    <td class="color-gray">Email:</td>
                    <td><?php echo BsHtml::textField('order_user[email]', $this->email, array('readonly' => 'true')) ;?></td>
                    <td>
                        <button class="btn btn-default btn_pencil"><span class="fa fa-pencil"></span></button>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <div class="block-title">Ответственный за обработку заказа</div>
            <div class="form-horizontal">
<?php
                echo
                    '<div class="form-group">
                        <div class="col-xs-4 color-gray">Менеджер:</div>
                        <div class="col-xs-8">' . BsHtml::dropDownList('order_user[manager_id]', $order->manager_id, CHtml::listData(Users::getManagers(), 'id', 'user_info.FullName'), array('empty' => '-')) . '</div>
                    </div>';

                $workers_for_role = CHtml::listData($workers, 'id', 'name', 'role');

                echo
                    '<div class="form-group">
                        <div class="col-xs-4 color-gray">Комплектовщик:</div>
                        <div class="col-xs-8">' . BsHtml::dropDownList('picker', $order->picker_id, ((isset($workers_for_role[Workers::ROLE_PICKER])) ? $workers_for_role[Workers::ROLE_PICKER] : array()), array('empty' => '-')) . '</div>
                    </div>';

                echo
                    '<div class="form-group">
                        <div class="col-xs-4 color-gray">Исполнитель:</div>
                        <div class="col-xs-8">' . BsHtml::dropDownList('executor', $order->executor_id, ((isset($workers_for_role[Workers::ROLE_EXECUTOR])) ? $workers_for_role[Workers::ROLE_EXECUTOR] : array()), array('empty' => '-')) . '</div>
                    </div>';
?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="block-title"><?php echo Yii::t('app', 'Customer Comment to the order') ;?></div>
            <div class="col-md-1">
                <span class="fa fa-exclamation-triangle color-yellow"></span>
            </div>
            <div class="col-md-11">
                <?php echo $order->comment ;?>
            </div>
        </div>

        <div class="col-md-12 labels">
            <div class="row">
                <div class="block-title col-md-2">Ярлыки</div>
                <a href="#" class="color-primary" id="add_note">+ Добавить ярлык</a>
            </div>
<?php
            for($i = 1; $i < 5; $i++)
            {
                $note = "note".$i;
                $_note = unserialize($order[$note]);
                $hidden = $_note["text"] ? '' : 'hidden';

                echo
                    '<div class="add-label row '.$hidden.'">
                        <div class="col-md-2">
                            '.BsHtml::dropDownList("note".$i."[label]", $_note["label"], array('primary' => 'primary', 'orange' => 'orange', 'red' => 'red', 'green' => 'green'), array('encode' => false, 'empty' => '-', 'class' => 'selectpicker')).'
                        </div>
                        <div class="col-md-10 label-input">
                            '.BsHtml::textField("note".$i."[text]", $_note["text"]).'
                            <span class="fa fa-close color-gray"></span>
                        </div>
                    </div>';
            }
?>
        </div>
<?php
        if ($order->type_delivery != Orders::ORDER_DELIVERY_NOT_ADDRESS)
        {
            $address = unserialize($order->address_text);

            $map_address = $address["country"].' '.$address["city"].' '.$address["street"].' '.$address["house"];
?>
            <div class="col-md-12">
                <div class="block-title"><?php echo Yii::t('app', 'Delivery address and map'); ?></div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tr>
                                <td class="color-gray"><?php echo Yii::t('app', 'Country'); ?>:</td>
                                <td><?php echo $address["country"] ;?></td>
                            </tr>
                            <tr>
                                <td class="color-gray"><?php echo Yii::t('app', 'City'); ?>:</td>
                                <td><?php echo $address["city"] ;?></td>
                            </tr>
                            <tr>
                                <td class="color-gray"><?php echo Yii::t('app', 'Street'); ?>:</td>
                                <td><?php echo $address["street"] ;?></td>
                            </tr>
                            <tr>
                                <td class="color-gray"><?php echo Yii::t('app', 'House'); ?>:</td>
                                <td><?php echo $address["house"] ;?></td>
                            </tr>
                            <tr>
                                <td class="color-gray"><?php echo Yii::t('app', 'Apartment'); ?>:</td>
                                <td><?php echo $address["apartment"] ;?></td>
                            </tr>
                            <tr>
                                <td class="color-gray"><?php echo Yii::t('app', 'Note to delivery') ;?>:</td>
                                <td><?php echo $order->delivery_comment ;?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
<?php
                        $this->widget('application.widgets.MapForAddressWidget',
                            array(
                                'address' => $map_address,
                                'height' => '400px',
                                'width' => '475px',
                            )
                        );
?>
                    </div>
                </div>
            </div>
<?php
        }
?>
        <div class="form-group buttons">
            <?php echo BsHtml::submitButton(Yii::t('app', 'Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
            <span><?php echo Yii::t('app', 'Cancel') ;?></span>
        </div>

    </div>
<?php
    if ($order->type_delivery != Orders::ORDER_DELIVERY_NOT_ADDRESS && isset($addr))
    {
?>
        <div class="row">
            <div class="block-title">Карта проезда:</div>
            <div class="" style="height: 400px">
<?php
                $this->widget('application.widgets.module_widgets.MapForAddressWidget',
                    array(
                        'address' => 'Республика Беларусь г.' . $addr,
                    )
                );
?>
            </div>
        </div>
<?php
    }

    $src = '
        $( document ).ready(function()
        {
            $(".labels button").find(".fa").remove();

            $(".labels button").prepend( "<span class=\'fa fa-lg fa-star color-"+($("#label option:selected").val())+"\'></span>" );

            $(".labels li .text").each(function()
            {
                $( this ).prepend( "<span class=\'fa fa-lg fa-star color-"+$(this).text()+"\'></span>" );
            });

            $(".labels li a").click(function(){
                $(this).closest(".bootstrap-select").find("button .fa").remove();
                $(this).closest(".bootstrap-select").find("button").prepend( "<span class=\'fa fa-lg fa-star color-"+$(this).text()+"\'></span>" );
            });
        });

        $("#add_note").on("click", function()
        {
            $(this).closest(".labels").find(".add-label.hidden").eq(0).removeClass("hidden");
            return false;
        });

        $(".add-label .fa-close").on("click", function()
        {
            $(this).siblings("input").val("");
            $(this).closest(".add-label").addClass("hidden");
            viewSubmitButton(this);
            return false;
        });



        $(".table_order_user .btn_pencil").on("click", function()
        {
            $(this).closest("tr").find("input").removeAttr("readonly");
            return false;
        });

        $(".selectpicker").selectpicker();
    ';
    $cs = Yii::app()->getClientScript();
    $cs->registerScript("datepicker", $src);