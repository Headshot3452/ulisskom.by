
<div class="form">

<!--    --><?php //echo $form->errorSummary($model);?>
    <?php if(isset($model->theme)) {?><div class="form-group row">
        <?php
        echo $form->label($model->theme, 'title', array('class' => 'control-label')); ?>
        <div class="">
            <?php echo $form->textField($model->theme, 'title', array('class' => 'form-control', "readonly"=>"true")); ?>
            <?php echo $form->error($model->theme,'title'); ?>
        </div>
    </div><?php }?>

    <div class="form-group row">
        <div class="">
            <?php echo $form->labelEx($model,'text'); ?>
        </div>
        <div class="">
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
            ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </div>

    <div class="form-group row">
        <div class="">
            <?php echo $form->labelEx($model,'note'); ?>
        </div>
        <div class="">
        <?php
        $this->widget('application.widgets.ImperaviRedactorWidget',array(
            'model'=>$model,
            'attribute'=>'note',
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
        <?php echo $form->error($model,'note'); ?>
        </div>
    </div>

</div><!-- form -->