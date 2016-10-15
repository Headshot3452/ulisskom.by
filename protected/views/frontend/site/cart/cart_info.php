<div class="container cart-info cart">
    <div class="row">
        <h1 class="col-md-12"><?php echo Yii::t('app','Drawing up of an order') ;?></h1>
    </div>
    <div class="row">
        <div class="col-md-12">
<?php
            $content = $this->widget('application.widgets.CartWidget', array(), 1);

            $form = $this->beginWidget('BsActiveForm',
                array(
                    'id' => 'example-advanced-form',
                    'enableAjaxValidation' => false,
                )
            );

            Yii::import('application.models.cart.*');

            $cartForm = new CartForm();

            $payment = new Payment();

            if(Yii::app()->user->isGuest)
            {
                $address = new Address();
                $user_info = new UserInfo();
                $user = new Users();
            }
            else
            {
                $address = Address::model()->active()->findByPk(Yii::app()->user->id);
                if(!$address)
                {
                    $address = new Address();
                }
                $user = Users::model()->active()->findByPk(Yii::app()->user->id);
                $user_info = $user->user_info;
            }
?>
            <h3><?php echo Yii::t('app', 'Contact Information') ;?></h3>
            <fieldset class="col-md-5 col-md-offset-2">
                <div class="text-uppercase title"><?php echo Yii::t('app', 'Personal information') ;?></div>
                <div class="form-group">

                    <?php echo $form->hiddenField($cartForm, 'products') ;?>

                    <?php echo CHtml::label(Yii::t('app', 'Last name').' *', '') ;?>
                    <?php echo $form->textField($user_info, 'last_name', array('class' => 'required form-control', 'placeholder' => Yii::t('app', 'Last name'))) ;?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::label(Yii::t('app', 'Name').' *', '') ;?>
                    <?php echo $form->textField($user_info, 'name', array('class' => 'required form-control', 'placeholder' => Yii::t('app', 'Name'))) ;?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::label(Yii::t('app', 'Patronymic'), '') ;?>
                    <?php echo $form->textField($user_info, 'patronymic', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Patronymic'))) ;?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::label('Email *', '') ;?>
                    <?php echo $form->textField($user, 'email', array('class' => 'required email form-control', 'placeholder' => Yii::t('app', 'Your e-mail'))) ;?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::label(Yii::t('app', 'Phone').' *', '') ;?>
                    <?php echo $form->textField($user_info, 'phone', array('class' => 'required form-control', 'placeholder' => Yii::t('app', 'Your phone number'))) ;?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::label(Yii::t('app', 'Comment'), '') ;?>
                    <?php echo CHtml::textArea('user_comment', '', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Comment'))) ;?>
                </div>
            </fieldset>

            <h3><?php echo Yii::t('app', 'Payment') ;?></h3>

            <fieldset class="col-md-5 col-md-offset-2">
                <div class="text-uppercase title"><?php echo Yii::t('app', 'Payment method') ;?></div>
                <div class="form-group">
                    <?php echo CHtml::label(Yii::t('app', 'Choose payment method').' *', '') ;?>
                    <?php echo CHtml::dropDownList('payment_type', '', Orders::model()->getTypePayment(), array('class' => 'required form-control')) ;?>
                </div>
                <div id="payment_cashless" style="display: none">
                    <div class="text-uppercase title">Информация по данному способу оплаты</div>
                    <div class="form-group">
                        <?php echo $form->label($payment, 'organization', array('label' => Yii::t('app', 'Name of organization (IE)').' *')) ;?>
                        <?php echo $form->textField($payment, 'organization', array('class' => 'required form-control', 'placeholder' => '')) ;?>
                    </div>
                    <div class="form-group">
                            <?php echo $form->label($payment, 'director', array('label' => Yii::t('app', 'Name of Director').' *')) ;?>
                        <?php echo $form->textField($payment, 'director', array('class' => 'required form-control', 'placeholder' => '')) ;?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->label($payment, 'organization_info', array('label' => Yii::t('app', 'Details of the organization').' *')) ;?>
                        <?php echo $form->textArea($payment, 'organization_info', array('class' => 'required form-control', 'placeholder' => '')) ;?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->label($payment, 'bank_info', array('label' => Yii::t('app', 'Bank details of the organization').' *')) ;?>
                        <?php echo $form->textArea($payment, 'bank_info', array('class' => 'required form-control', 'placeholder' => '')) ;?>
                    </div>
                </div>
            </fieldset>

            <h3><?php echo Yii::t('app', 'Delivery');?></h3>
            <fieldset class="col-md-5 col-md-offset-2">
                <div class="row">
                    <div class="text-uppercase title col-md-12"><?php echo Yii::t('app', 'Delivery method');?></div>
                    <div class="form-group col-md-12">
                        <?php echo CHtml::label(Yii::t('app', 'Choose delivery method').' *', '') ;?>
                        <?php echo CHtml::dropDownList('delivery_type', '', Orders::model()->getTypeDelivery(), array('class' => 'required form-control')) ;?>
                    </div>
                    <div id="del_adr" style="display: none">
                        <div class="text-uppercase title col-md-12">Информация по данному способу доставки</div>
                        <div class="form-group deliv-sum col-md-12">
                            <label>Стоимость доставки:</label>
                            <div>
                                <span class="primary-color text-uppercase">10.00</span>
                                <span class="text-uppercase gray-color">Byr</span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Бесплатно от:</label>
                            <div>
                                <span class="primary-color">110.00</span> <span
                                    class="text-uppercase gray-color">Byr</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p>
                                    Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты.
                                    Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового
                                    океана.
                                </p>
                            </div>
                        </div>

                        <div class="text-uppercase title col-md-12"><?php echo Yii::t('app', 'Delivery address') ;?></div>

                        <div class="form-group col-md-12">
                            <?php echo $form->labelEx($address, 'country') ;?>
                            <?php echo $form->dropDownList($address, 'country', $this->getCountryFromAPI(), array('class' => 'required form-control')) ;?>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->labelEx($address, 'city') ;?>
                            <?php echo $form->textField($address, 'city', array('class' => 'required form-control')) ;?>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->labelEx($address, 'street') ;?>
                            <?php echo $form->textField($address, 'street', array('class' => 'required form-control')) ;?>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->labelEx($address, 'house') ;?>
                            <?php echo $form->textField($address, 'house', array('class' => 'required form-control')) ;?>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->labelEx($address, 'apartment') ;?>
                            <?php echo $form->textField($address, 'apartment', array('class' => 'form-control')) ;?>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->labelEx($address, 'index') ;?>
                            <?php echo $form->textField($address, 'index', array('class' => 'required form-control')) ;?>
                        </div>

                        <div class="text-uppercase title col-md-12"><?php echo Yii::t('app', 'Date and time of delivery') ;?></div>

                        <div class="form-group col-md-12">
                            <?php echo CHtml::label(Yii::t('app', 'The estimated delivery date').' *', '') ;?>
                            <?php echo CHtml::textField('date', '', array('class' => 'required  form-control', 'placeholder' => '')) ;?>
                            <span class="fa fa-calendar primary-color"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo CHtml::label(Yii::t('app', 'Convenient time'), '') ;?>
                            <?php echo CHtml::dropDownList('time', '', Orders::getDeliverySchedule(), array('class' => 'form-control')) ;?>
                        </div>

                        <div class="text-uppercase title col-md-12"><?php echo Yii::t('app', 'Comments deliverable') ;?></div>

                        <div class="form-group col-md-12">
                            <?php echo CHtml::label(Yii::t('app', 'TextComment'), '') ;?>
                            <?php echo CHtml::textArea('delivery_comment', '', array('class' => 'form-control', 'rows' => 4, 'placeholder' => Yii::t('app', 'Enter the text'))) ;?>
                        </div>
                    </div>
                </div>
            </fieldset>

            <h3><?php echo Yii::t('app', 'The confirmation') ;?></h3>
            <fieldset>
                <div class="row">
                    <div class="text-uppercase title col-md-12">Список товаров</div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php echo $content ;?>
                        </div>
                        <div class="row">
                            <div class="table-responsive col-md-7">
                                <table class="table table-hover border-bottom all">
                                    <tr>
                                        <td class="gray-color">Всего товаров:</td>
                                        <td class="count-product">0</td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">Доставка:</td>
                                        <td>0 <span class="gray-color text-uppercase">Byr</span></td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">Скидка:</td>
                                        <td><span class="red-color sale-product">0</span> <span class="gray-color text-uppercase">Byr</span></td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">Общая сумма:</td>
                                        <td class="result-sum"><b class="total-price">0</b> <span class="gray-color text-uppercase">Byr</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-uppercase title col-md-7">Личные данные</div>
                            <div class="table-responsive col-md-7">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="gray-color">Фамилия:</td>
                                        <td id="res_familiya"><?php echo $user_info->last_name ;?></td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">Имя:</td>
                                        <td id="res_name"><?php echo $user_info->name ;?></td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">Отчество:</td>
                                        <td id="res_patronymic"><?php echo $user_info->patronymic ;?></td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">E-mail:</td>
                                        <td id="res_email"><?php echo $user->email ;?></td>
                                    </tr>
                                    <tr>
                                        <td class="gray-color">Телефон:</td>
                                        <td id="res_phone"><?php echo $user_info->phone ;?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="text-uppercase title col-md-7">Способ оплаты</div>
                            <div class="table-responsive col-md-7">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="gray-color">Выбранный способ:</td>
                                        <td id="res_payment">Наличные</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="text-uppercase title col-md-7">Способ доставки</div>
                            <div class="table-responsive col-md-7">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="gray-color">Выбранный способ:</td>
                                        <td id="res_delivery">Самовывоз</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="address_delivery" style="display: none;">
                                <div class="text-uppercase title col-md-7 address_delivery">Адрес доставки</div>
                                <div class="table-responsive col-md-7">
                                    <table class="table table-hover">
                                        <tr>
                                            <td class="gray-color">Страна:</td>
                                            <td id="res_country"></td>
                                        </tr>
                                        <tr>
                                            <td class="gray-color">Населенный пункт:</td>
                                            <td id="res_city"></td>
                                        </tr>
                                        <tr>
                                            <td class="gray-color">Улица:</td>
                                            <td id="res_street"></td>
                                        </tr>
                                        <tr>
                                            <td class="gray-color">Номер дома:</td>
                                            <td id="res_house"></td>
                                        </tr>
                                        <tr>
                                            <td class="gray-color">Номер квартиры:</td>
                                            <td id="res_apartament"></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="text-uppercase title col-md-7">Комментарии к доставке</div>
                                <div class="col-md-7 comment">
                                    <p class="border-bottom" id="res_comment"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </fieldset>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<!-- Modal OK-->

<div class="modal fade" id="cartOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Отправка завершена</h3>
            </div>
            <div class="modal-body">
                <h2 class=""><b>Ваш заказ принят</b></h2>

                <p>
                    Подробности заказа отправлены на почтовый<br> адрес, который вы указали
                </p>
                <p><b>Спасибо!</b></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Готово</button>
            </div>
        </div>
    </div>
</div>

<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile('/js/steps/jquery.form.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/steps/jquery.validate.min.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/steps/jquery.steps.js', CClientScript::POS_END);

    $src = '

        $("body").on("change", "#UserInfo_last_name", function(){$("#res_familiya").text($(this).val());});
        $("body").on("change", "#UserInfo_name", function(){$("#res_name").text($(this).val());});
        $("body").on("change", "#UserInfo_patronymic", function(){$("#res_patronymic").text($(this).val());});
        $("body").on("change", "#Users_email", function(){$("#res_email").text($(this).val());});
        $("body").on("change", "#UserInfo_phone", function(){$("#res_phone").text($(this).val());});
        $("body").on("change", "#payment_type", function(){$("#res_payment").text($("#payment_type option:selected").text());});
        $("body").on("change", "#delivery_type", function(){$("#res_delivery").text($("#delivery_type option:selected").text());});
        $("body").on("change", "#Address_country", function(){$("#res_country").text($("#Address_country option:selected").text());});
        $("body").on("change", "#Address_city_id", function(){$("#res_city").text($(this).val());});
        $("body").on("change", "#Address_street", function(){$("#res_street").text($(this).val());});
        $("body").on("change", "#Address_house", function(){$("#res_house").text($(this).val());});
        $("body").on("change", "#Address_apartment", function(){$("#res_apartament").text($(this).val());});
        $("body").on("change", "#delivery_comment", function(){$("#res_comment").text($(this).val());});

        var form = $("#example-advanced-form").show();

        form.steps(
        {
            headerTag: "h3",
            titleTemplate: "<span class=\"number text-uppercase\">Шаг #index#.</span> #title#  <span class=\"fa fa-arrow-circle-right\"></span>",
            labels: {
                cancel: "Отмена",
                current: "",
                finish: "Заказать",
                next: "Далее",
                previous: "Назад",
                loading: "Loading ..."
            },
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                //form.validate().settings.ignore = ":disabled";
                return true;
            },
            onFinished: function (event, currentIndex)
            {
                var data = $("#example-advanced-form").serialize();

                $.ajax(
                {
                    type: "POST",
                    url: "/cart/",
                    data: data
                })
                .success(function( msg )
                {
                    alert( msg );
                    $("#cartOk").modal("show");
                });
            }
        }).validate(
        {
            errorPlacement: function errorPlacement(error, element)
            {
                element.before(error);
            },
            rules:
            {

            },
            messages:
            {
                "UserInfo[last_name]": "'.Yii::t("app", "Please enter your last name").'",
                "UserInfo[name]": "'.Yii::t("app", "Please enter your name").'",
                "Users[email]":
                {
                    required: "'.Yii::t("app", "Please enter your email").'",
                    email: "'.Yii::t("app", "Please enter a valid email address").'",
                },
                "UserInfo[phone]": "'.Yii::t("app", "Please enter your phone").'",
                "Payment[organization]": "'.Yii::t("app", "Please enter your organization (IE)").'",
                "Payment[director]": "'.Yii::t("app", "Please enter name of director").'",
                "Payment[organization_info]": "'.Yii::t("app", "Please enter details of the organization").'",
                "Payment[bank_info]": "'.Yii::t("app", "Please enter bank details").'",
                "date": "'.Yii::t("app", "Please enter enter the delivery date").'",
            }
        });

        initCartRactive();

        $(".price b, .price_total_item b").each(function()
        {
            $(this).text( number_format($(this).text(), 2, ".", " ") );
        });

        $("#payment_type").change(function ()
        {
            if($(this).val() == 2)
            {
                $("#payment_cashless").css({"display":"block"});
            }
            else
            {
                $("#payment_cashless").css({"display":"none"});
            }
        });

        $("#delivery_type").change(function ()
        {
            if($(this).val() == 2 || $(this).val() == 3)
            {
                $("#del_adr").css({"display":"block"});
                $(".address_delivery").css({"display":"block"});

                $("#res_country").text($("#Address_country option:selected").text());
                $("#res_city").text($("#Address_city_id").val());
                $("#res_street").text($("#Address_street").val());
                $("#res_house").text($("#Address_house").val());
                $("#res_apartament").text($("#Address_apartment").val());
            }
            else
            {
                $("#del_adr").css({"display":"none"});
                $(".address_delivery").css({"display":"none"});
            }
        });

        $.datepicker.setDefaults(
              $.extend($.datepicker.regional["ru"])
        );
        $("#date").datepicker({
            dateFormat: "dd.mm.yy",
            showOtherMonths: true
        });

        $(".actions a").click(function()
        {
            if($("#example-advanced-form-p-3").hasClass("current"))
            {
                $(".actions").removeClass("col-md-5 col-md-offset-2").addClass("col-md-7");
            }
            else
            {
                $(".actions").removeClass("col-md-7").addClass("col-md-5 col-md-offset-2");
            }
        });
    ';
    $cs->registerScript('steps', $src);