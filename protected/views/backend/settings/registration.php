<?php
    /* @var $this UsersController */
    /* @var $model Users */
    /* @var $form BsActiveForm */
?>

<div class="row settings-registration">

    <div class="form">
<?php
        $form = $this->beginWidget('bootstrap.widgets.BsActiveForm',
            array(
                'id' => 'users-registration',
                'enableAjaxValidation' => false,
            )
        );
?>
        <div class="require col-xs-5 col-xs-offset-4">
            <span class="fa fa-exclamation-circle"></span>
            <span class="notice">Заполните все поля, отмеченные звёздочкой « * »</span>
        </div>

        <div class="clearfix"></div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user_info, 'last_name'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($user_info, 'last_name', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user_info, 'last_name'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user_info,'name'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($user_info, 'name', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user_info, 'name'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user_info, 'patronymic'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($user_info, 'patronymic', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user_info, 'patronymic'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right birth-label">
                <?php echo $form->labelEx($user_info, 'birth'); ?>
            </div>
            <div class="col-xs-5 all date-block">
                <div class="col-xs-4 field-note">
                    <label>Число</label>
                    <?php echo $form->dropDownList($user_info, 'birth_day', array_combine(range(1, 31), range(1, 31)),array('class' => "form-control")); ?>
                </div>
                <div class="col-xs-4 field-note">
                    <label>Месяц</label>
                    <?php echo $form->dropDownList($user_info,'birth_month', array_combine(range(1, 12), range(1, 12)), array('class' => "form-control")); ?>
                </div>
                <div class="col-xs-4 field-note">
                    <label>Год</label>
                    <?php echo $form->dropDownList($user_info, 'birth_year', array_combine(range(date('Y')-18, 1910), range(date('Y')-18, 1910)),array('class' => "form-control")); ?>
                </div>
                <div class="col-xs-4"> <?php echo $form->error($user_info, 'birth'); ?></div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user, 'email'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($user, 'email', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user, 'email'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user_info, 'phone'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($user_info, 'phone', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user_info, 'phone'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <h3 class="lk_cat text-left col-xs-5 col-xs-offset-4">Пароль</h3>
        <div class="clearfix"></div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user, 'password'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->passwordField($user, 'password', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user, 'password'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($user, 'password_confirm'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->passwordField($user, 'password_confirm', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($user, 'password_confirm'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <h3 class="lk_cat text-left col-xs-5 col-xs-offset-4">Основной адрес</h3>
        <div class="clearfix"></div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($address,'country'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->dropDownList($address, 'country', $this->getCountryFromAPI(), array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($address, 'country'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($address,'index'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($address, 'index', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($address, 'index'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($address, 'city_id'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($address, 'city_id', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($address, 'city_id'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($address, 'street'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($address, 'street', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($address, 'street'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group house">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($address, 'house'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($address, 'house', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($address, 'house'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group house">
            <div class="col-xs-4 text-right">
                <?php echo $form->labelEx($address, 'apartment'); ?>
            </div>
            <div class="col-xs-5">
                <?php echo $form->textField($address, 'apartment', array('class' => 'form-control', 'placeholder' => '')); ?>
                <?php echo $form->error($address, 'apartment'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row buttons">
            <div class="form-group">
                <div class="col-xs-4"></div>
                <div class="col-xs-5">
<?php
                    echo BsHtml::submitButton(Yii::t('app', 'Register'), array('id' => 'reg_btn', 'color' => BsHtml::BUTTON_COLOR_PRIMARY));
                    echo '<a href="/admin/'.CHtml::normalizeUrl('settings/permission').'">Отмена</a>'
?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>