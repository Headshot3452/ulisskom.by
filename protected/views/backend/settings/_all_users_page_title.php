<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerPackage('hint');
?>

<div class="one_item users">
    <div class="row">
        <div class="col-xs-1 img-cont no-left">
            <a href="<?php echo $this->createUrl('index'); ?>">
                <img src="/images/all_users.png" alt="" title="">
            </a>
        </div>
        <span class="pull-left title">Пользователи</span>

<?php
        $form = $this->beginWidget('BsActiveForm',
            array(
                'id' => 'users-filter-form',
                'enableAjaxValidation' => false,
            )
        );
?>
        <div class="form-group">
<?php
            echo $form->label($model, 'email', array('label' => 'E-mail:'));
            echo $form->textField($model, 'email', array('placeholder' => ''));
?>
            <span class="glyphicon glyphicon-search pull-right"></span>
        </div>

        <div class="form-group">
<?php
            echo $form->label($model, 'role', array('label' => 'Права доступа (роль):'));
            echo $form->dropDownList($model, 'role', $model->getRoleForFilter());
?>
        </div>
        <div class="form-group">
<?php
            echo $form->label($model, 'create_time', array('label' => 'Дата создания:'));

            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'model' => $model,
                    'attribute' => 'create_time',
                    'options' => array(
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                    ),
                )
            );
?>
        </div>
        <div class="form-group">
<?php
            echo $form->label($model, 'update_time', array('label' => 'Редактирование:'));

            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'model' => $model,
                    'attribute' => 'update_time',
                    'options' => array(
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                    ),
                )
            );
?>
        </div>
        <a id="reset-date" class="btn btn-default hint--bottom hint--rounded" data-hint="Сбросить фильтр"><span class="reset"></span></a>

        <div class="clearfix"></div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript" src="/js/jqueryui/datepicker-ru.js"></script>
<script>

    $(function ()
    {
        $('#reset-date').on('click', function ()
        {
            $('#Users_email').val(null);
            $('#Users_role').val('0');
            $('#Users_create_time, #Users_update_time').datepicker("setDate", null);
            $("#users-filter-form").submit();
        });

        $(".glyphicon-search").on('click', function ()
        {
            $("#users-filter-form").submit();
        });

        $(".form-control").on('change', function ()
        {
            $("#users-filter-form").submit();
        });

        $.datepicker.setDefaults(
            $.extend($.datepicker.regional["ru"])
        );
        $('#Users_create_time, #Users_update_time').datepicker({dateFormat: "dd.mm.yy", showOtherMonths: true});
    });

</script>
