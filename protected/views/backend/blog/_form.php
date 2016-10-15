<div class="row">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'enableAjaxValidation' => false,
        'id'=>'feedback-form',
    ));
    ?>
    <div class="col-xs-4 info-ask">
        <div class="label-block">
            <?php echo Yii::t('app', 'Client'); ?>
        </div>
        <div class="row info-user">
            <div class="col-xs-2 image-user">
                <?php
                    $images = $model->user->getOneFile('small');

                    if(!empty($images))
                        echo CHtml::image($images, $model->user->getFullName());
                    else
                        echo CHtml::image('/'.Yii::app()->params['noavatar']);
                ?>
            </div>
            <div class="col-xs-8">
                <div>&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->user->id; ?></div>
                <div>
                    <img src="/images/feedback_user.png">
                    <?php echo $model->user->getFullName(); ?>
                </div>
                <div>
                    <img src="/images/feedback_user.png">
                    <?php echo $model->user->user_info->nickname; ?>
                </div>
                <div>
                    <img src="/images/feedback_email.png">
                    <?php echo $model->user->email; ?>
                </div>
            </div>
            <div class="col-xs-12 cause-remove">
                <div class="label-block">Примечания / причина удаления:</div>
                <?php echo $form->textarea($model, 'cause', array('class'=>'form-control')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-8 feedback-form blog-form">
    <div class="form form-structure">

    <div class="form-group">
            <div class="label-block">Заголовок поста:</div>
            <div class="text-info">
                <?php echo $model->title; ?>
            </div>
    </div>

    <div class="form-group primech post-text">
        <div class="label-block">Пост:</div>
        <?php
        $this->widget('application.widgets.ImperaviRedactorWidget',array(
            'model'=>$model,
            'attribute'=>'text',
            'plugins' => array(
                'imagemanager' => array(
                    'js' => array('imagemanager.js',),
                ),
                'filemanager' => array(
                    'js' => array('filemanager.js',),
                ),
                'fullscreen'=>array(
                    'js'=>array('fullscreen.js'),
                ),
                'table'=>array(
                    'js'=>array('table.js'),
                ),
            ),
            'options'=>array(
                'lang'=>Yii::app()->language,
                'imageUpload'=>$this->createUrl('admin/imageImperaviUpload'),
                'imageManagerJson'=>$this->createUrl('admin/imageImperaviJson'),
                'fileUpload'=>$this->createUrl('admin/fileImperaviUpload'),
                'fileManagerJson'=>$this->createUrl('admin/fileImperaviJson'),
                'uploadFileFields'=>array(
                    'name'=>'#redactor-filename'
                ),
                'changeCallback'=>'js:function()
                {
                    viewSubmitButton(this.$element[0]);
                }',
                'buttonSource'=> true,
            ),
        ));
            echo '<div class="text-info">'.$model->text.'</div>';
        ?>
        <?php echo $form->error($model,'text'); ?>
    </div>

    <?php echo $form->hiddenField($model, 'status', array('class'=>'hidden-status')); ?>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
    </div>
</div>

<?php
$status_feedback="
    $('.status-feedback ul a').on('click', function(){
        var value = $(this).attr('id');

        $('.status-feedback button').html($(this).html()+'<span class=\"caret\"></span>');
        $('.hidden-status').val(value);

        var color;

        if(value==1)
            color = 'blue';
        if(value==2)
            color = 'orange';
        if(value==4)
            color = 'green';
        if(value==5)
            color = 'red';

        $('.status-feedback').css('border-color',color);
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('status_feedback',$status_feedback);

?>