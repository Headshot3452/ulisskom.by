<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerPackage('hint');
    $image = $model->getOneFile('original');

    if (!$image)
    {
        $image = Yii::app()->params['noavatar'];
    }
?>
<div id="user_item_setting">
    <div class="table-img"><img src="/<?php echo $image ;?>"/></div>
    <div class="number-user"># <?php echo $model->id ;?></div>
    <div class="user">
        <img src="/images/icon-admin/little_user_company.png"/><?php echo $model->user_info->getFullName() ;?>
    </div>
    <div class="mail">
        <img src="/images/icon-admin/little_message_company.png"/><?php echo $model->email ;?>
    </div>
    <div class="phone">
        <img src="/images/icon-admin/little_phone.png"/><?php echo $model->user_info->phone ;?>
    </div>
    <div class="user_settings">
<?php
        $form = $this->beginWidget('BsActiveForm',
            array(
                'id' => 'role',
                'enableAjaxValidation' => true,
                'enableClientValidation'=>false,
                'htmlOptions' => array(
                    'class' => 'form-horizontal col-xs-12 left',
                ),
                'clientOptions'=>array(
                    'validateOnChange'=>true,
                ),
            )
        );
?>
        <div class="form-group">
<?php
            echo $form->label($model, 'role', array('label' => 'Права доступа (роль):'));
            echo $form->dropDownList($model, 'role', $model->getRole(),
                array(
                    'ajax' => array(
                        'type' => 'GET',
                        'url' => CController::createUrl('settings/permission'),
                        'success' => 'function(html, script, script1)
                        {
                            alert("Изменения сохранены!");
                        }',
                        'data' => array(
                            'id_role' => 'js:this.value',
                            'id' => $model->id,
                            'to' => 'models'
                        ),
                    ),
                )
            );
?>
        </div>
        <a href="<?php echo $this->createUrl('active', array('id' => $model->id)) ?>"
           class="btn btn-small btn-active hint--bottom hint--rounded" data-hint="<?php echo($model->status == CatalogProducts::STATUS_OK ? 'Есть доступ' : 'Нет доступа'); ?>"><span
            class="icon-admin-power-switch-<?php echo($model->status == CatalogProducts::STATUS_OK ? 'green' : 'red'); ?>"></span></a>
        <button type="button" class="btn btn-default" data-toggle="dropdown">
            <span class="fa fa-bars"></span>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo $this->createUrl('delete_user', array('id' => $model->id )) ?>" role="button" class="remove-ip action-ip">Удалить</a></li>
            <li><a href="#modal_archiv" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В архив</a></li>
        </ul>
        <?php $this->endWidget(); ?>
    </div>
</div>