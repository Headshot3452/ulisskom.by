<div id="user_item_setting">
    <div class="col-xs-6">
        <span class="pull-left title">Отзыв # <?php echo $model->id; ?></span><span class="date-time"><?php echo date('d.m.Y в H:i',$model->create_time); ?></span>
    </div>

    <div class="user_settings">
        <?php
        $form = $this->beginWidget('BsActiveForm', array(
                'id' => 'status',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'htmlOptions' => array(
                    'class' => 'form-horizontal col-xs-12 left',
                ),
                'clientOptions' => array(
                    'validateOnChange' => true,
                ),
            )
        );
        ?>
        <div class="form-group">
            <?php
            echo $form->label($model, 'status', array('label' => 'Статус:'));
            echo '<div class="border status-'.$model->status.'">'.$form->dropDownList($model, 'status', $model->getFilterStatus(), array(
                'ajax' => array(
                    'type' => 'GET',
                    'url' => CController::createUrl('review/index'),
                    'success' => 'function(html,script,script1)
                        {
                           alert("Изменения сохранены!");
                        }',
                    'data' => array(
                        'id_status' => 'js:this.value',
                        'id' => $model->id,
                        'to' => 'models'
                    ),
                ),
            )).'</div>';
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!--</div>-->