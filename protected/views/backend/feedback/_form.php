<?php $files=unserialize($model->files); ?>

<div class="row">
    <div class="col-xs-4 info-ask">
        <div class="label-block"><?php echo Yii::t('app', 'Client'); ?></div>
        <div class="row inform">
            <div class="col-xs-8">
                <div class="feedback_system">
                <?php
                foreach(SettingsFeedback::model()->findAll('system=1') as $key => $value) { ?>
                    <div class="feedback_system">
                        <?php
                        if($key==0)
                            echo '<img src="/images/icon-admin/little_user_company.png">';
                        if($key==1)
                            echo '<img src="/images/icon-admin/little_phone.png">';
                        if($key==2)
                            echo '<img src="/images/icon-admin/little_message_company.png">';
                        ?>
                        <?php
                            $feedback = FeedbackAnswers::getAnswersForFeedback($value->id, $model->id);
                            echo isset($feedback->value)?$feedback->value:'';
                        ?>
                    </div>
                <?php } ?>
                <?php
                foreach(FeedbackAnswers::getFeedbackAnswers($model->parent_id) as $key => $value){?>
                    <div class="feedback_system">
                        <?php echo $value->name; ?>:
                        <?php
                            $feedback = FeedbackAnswers::getAnswersForFeedback($value->id, $model->id);
                            echo isset($feedback->value)?$feedback->value:'';
                        ?>
                    </div>
                <?php }?>
                </div>
            </div>
        </div>
        <div class="ulpoad-file">
            <?php if(!empty($files)): ?>
            <div class="label-block">Загруженный файл</div>
                <?php 
                    foreach($files as $file)
                    {
                        echo '<a href="?id='.$model->id.'&name='.$file['name'].'"><img src="/images/icon-admin/file.png">'.$file['filename'].'</a>';
                    }
                ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-xs-8 feedback-form">
    <div class="form form-structure">
    <?php
        $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
            'enableAjaxValidation' => false,
            'id'=>'feedback-form',
        ));
    ?>

    <div class="form-group">
            <div class="label-block"><?php echo Yii::t('app', 'Theme ask'); ?>:</div>
            <input type="text" value="<?php echo $model->tree->title; ?>" class="form-control" readonly>
    </div>

    <div class="form-group ask">
            <div class="label-block"><?php echo Yii::t('app', 'Ask'); ?>:</div>
            <?php
            $this->widget('application.widgets.ImperaviRedactorWidget',array(
                'model'=>$model,
                'attribute'=>'ask',
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
            ?>
            <?php echo $form->error($model,'ask'); ?>
    </div>

    <div class="form-group primech">
        <div class="label-block"><?php echo $form->labelEx($model,'primech'); ?>:</div>
        <?php
        $this->widget('application.widgets.ImperaviRedactorWidget',array(
            'model'=>$model,
            'attribute'=>'primech',
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
        ?>
        <?php echo $form->error($model,'primech'); ?>
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
        if(value==5)
            color = '#fb6b00';
        if(value==2)
            color = 'green';
        if(value==3)
            color = 'gray';
        if(value==4)
            color = 'red';

        $('.status-feedback').css('border-color',color);
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('status_feedback',$status_feedback);

?>