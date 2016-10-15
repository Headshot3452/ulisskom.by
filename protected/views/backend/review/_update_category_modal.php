
<!-- Modal -->
<div class="modal fade" id="update_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $form = $this->beginWidget('BsActiveForm', array(
                'id' => 'edit-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'action' => $this->createUrl('updateTheme'). '?id=' .$edit->id,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'afterValidate' => 'js:function(form, data, hasError) {
                                            if (!hasError){
                                                $("#update_category").modal("hide");
                                                $.ajax({
                                                    dataType: "json",
                                                });
                                                location.reload();
                                            }}',
                    'errorCssClass' => 'has-error',
                ),
            ));?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title  text-center" id="myModalLabel">Редактировать тему отзыва</h4>
            </div>
            <div class="modal-body no-padding">
                <div class="form-group">
                    <?php echo $form->textField($edit, 'title' , array('placeholder'=>'')); ?>
                    <?php echo $form->error($edit, 'title'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Сохранить</button>
                <a data-dismiss="modal">Отмена</a>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="create_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $form = $this->beginWidget('BsActiveForm', array(
                'id' => 'create-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'action' => $this->createUrl('createTheme'). '?id_parent=' .$edit->id,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'afterValidate' => 'js:function(form, data, hasError) {
                                            if (!hasError){
                                                $("#create_category").modal("hide");
                                                $.ajax({
                                                    dataType: "json",
                                                });
                                                location.reload();
                                            }}',
                    'errorCssClass' => 'has-error',
                ),
            ));
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Добавить тему отзыва</h4>
            </div>
            <div class="modal-body no-padding">
                <div class="form-group">
                    <?php echo $form->textField($new, 'title' , array('placeholder'=>'')); ?>
                    <?php echo $form->error($new, 'title'); ?>
                    <?php echo $form->hiddenField($new, 'level'); ?>
                    <?php echo $form->error($new, 'level'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Сохранить</button>
                <a data-dismiss="modal">Отмена</a>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>