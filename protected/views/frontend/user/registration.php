<?php
    /* @var $this UsersController */
    /* @var $model Users */
    /* @var $form BsActiveForm */

    $cs = Yii::app()->getClientScript();
    $src = '
        $(".btn-group .btn.female").click(function ()
        {
            $(".btn-group .btn.male").removeClass("active");
            $(this).addClass("active");
            $("input#UserInfo_sex").val(1);
        });

        $(".btn-group .btn.male").click(function ()
        {
            $(".btn-group .btn.female").removeClass("active");
            $(this).addClass("active");
            $("input#UserInfo_sex").val(2);
        });
    ';
    $cs->registerScript('checks', $src);
?>

<div class="form widget col-md-6 col-md-offset-3">
    <div class="title row border-bottom">
        <h4>
            Регистрация пользователя
        </h4>
    </div>
    <div class="body row">
        <div class="require col-md-12">
            <span class="fa fa-exclamation-triangle"></span>
            <span class="notice">Заполните все поля, отмеченные звёздочкой « * »</span>
        </div>
        <div class="col-md-12 text-uppercase label-title">Личные данные</div>

        <div class="form">
<?php
            $form = $this->beginWidget('bootstrap.widgets.BsActiveForm',
                array(
                    'id' => 'users-registration',
                    'enableAjaxValidation' => false,
                )
            );
?>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user_info, 'last_name'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($user_info, 'last_name', array('class' => 'form-control', 'placeholder' => 'Фамилия')); ?>
                    <?php echo $form->error($user_info, 'last_name'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user_info, 'name'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($user_info, 'name', array('class' => 'form-control', 'placeholder' => 'Имя')); ?>
                    <?php echo $form->error($user_info, 'name'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user_info, 'patronymic'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($user_info, 'patronymic', array('class' => 'form-control', 'placeholder' => 'Отчество')); ?>
                    <?php echo $form->error($user_info, 'patronymic'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user_info, 'sex'); ?>
                    <?php echo $form->hiddenField($user_info, 'sex'); ?>
                </div>
                <div class="col-md-12 btn-group">
                        <button type="button" class="btn btn-default female col-md-6"><span class="fa fa-female"></span> Женский</button>
                        <button type="button" class="btn btn-default male col-md-6"><span class="fa fa-male"></span> Мужской</button>
                    <?php echo $form->error($user_info, 'sex'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user_info, 'birth'); ?>
                </div>
                <div class="col-md-12 all date-block">
                    <div class="col-md-4 field-note">
                        <?php echo $form->dropDownList($user_info, 'birth_day', array_combine(range(1, 31), range(1, 31)), array('class' => "form-control", 'placeholder' => 'Число')); ?>
                    </div>
                    <div class="col-md-4 field-note">
                        <?php echo $form->dropDownList($user_info, 'birth_month', array_combine(range(1, 12), range(1, 12)), array('class' => "form-control", 'placeholder' => 'Месяц')); ?>
                    </div>
                    <div class="col-md-4 field-note">
                        <?php echo $form->dropDownList($user_info, 'birth_year', array_combine(range(date('Y') - 18, 1910), range(date('Y') - 18, 1910)), array('class' => "form-control", 'placeholder' => 'Год')); ?>
                    </div>
                    <div class="col-md-12"> <?php echo $form->error($user_info, 'birth'); ?></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user, 'email'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($user, 'email', array('class' => 'form-control', 'placeholder' => 'Ваш e-mail адрес')); ?>
                    <?php echo $form->error($user, 'email'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user_info, 'phone'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($user_info, 'phone', array('class' => 'form-control', 'placeholder' => 'Ваш номер телефона')); ?>
                    <?php echo $form->error($user_info, 'phone'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12 text-uppercase label-title">создание пароля</div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user, 'password'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->passwordField($user, 'password', array('class' => 'form-control', 'placeholder' => 'Придумайте свой пароль')); ?>
                    <?php echo $form->error($user, 'password'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($user, 'password_confirm'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->passwordField($user, 'password_confirm', array('class' => 'form-control', 'placeholder' => 'Повторите свой пароль')); ?>
                    <?php echo $form->error($user, 'password_confirm'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12 text-uppercase label-title">Основной адрес доставки</div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($address, 'country'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->dropDownList($address, 'country', $this->getCountryFromAPI(), array('class' => '', 'placeholder' => 'Страна')); ?>
                    <?php echo $form->error($address, 'country'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($address, 'index'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($address, 'index', array('class' => 'form-control', 'placeholder' => 'Индекс')); ?>
                    <?php echo $form->error($address, 'index'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <?php echo $form->labelEx($address, 'city_id'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($address, 'city_id', array('class' => 'form-control', 'placeholder' => 'Населенный пункт')); ?>
                    <?php echo $form->error($address, 'city_id'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

<div class="form-group">
    <div class="col-md-12">
        <?php echo $form->labelEx($address, 'street'); ?>
    </div>
    <div class="col-md-12">
        <?php echo $form->textField($address, 'street', array('class' => 'form-control', 'placeholder' => 'Улица')); ?>
        <?php echo $form->error($address, 'street'); ?>
    </div>
    <div class="clearfix"></div>
</div>

<div class="form-group house col-md-6">
    <div class="">
        <?php echo $form->labelEx($address, 'house'); ?>
    </div>
    <div class="">
        <?php echo $form->textField($address, 'house', array('class' => 'form-control', 'placeholder' => 'Номер')); ?>
        <?php echo $form->error($address, 'house'); ?>
    </div>
    <div class="clearfix"></div>
</div>

<div class="form-group house col-md-6">
    <div class="">
        <?php echo $form->labelEx($address, 'apartment'); ?>
    </div>
    <div class="">
        <?php echo $form->textField($address, 'apartment', array('class' => 'form-control', 'placeholder' => 'Номер')); ?>
        <?php echo $form->error($address, 'apartment'); ?>
    </div>
    <div class="clearfix"></div>
</div>

<div class="col-md-12 text-uppercase label-title">Подтверждение</div>

<div class="clearfix"></div>

<?php
if (CCaptcha::checkRequirements() && Yii::app()->user->issetCaptcha()) {
    ?>
    <div class="form-group captcha">
        <div class="col-md-12">
            <?php echo CHtml::activeLabelEx($user, 'captcha'); ?>
        </div>
        <div class="col-md-12">
            <div class="col-md-6 left">
                <?php echo $form->textField($user, 'captcha', array('class' => 'form-control', 'placeholder' => '')); ?>
            </div>
            <div class="col-md-6 captcha">
                <?php $this->widget('CCaptcha', array(
                    'clickableImage' => true,
                    'buttonLabel' => '<span class="fa fa-refresh"></span>',
                    'buttonOptions' => array('class' => 'captcha-refresh blue_link'))
                );?>
            </div>
        </div>
        <div class="col-md-12"> <?php echo $form->error($user, 'captcha'); ?></div>
        <div class="clearfix"></div>
    </div>
<?php
}
?>

    <div class="form-group">
        <div class="col-md-12">
            <?php
            echo BsHtml::submitButton(Yii::t('app', 'Register'), array('id' => 'reg_btn', 'color' => BsHtml::BUTTON_COLOR_PRIMARY));
            echo CHtml::link('Отмена', '/',array('class'=>'cancel_link'));
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php $this->endWidget(); ?>

</div>
<!-- form -->
</div>
</div>