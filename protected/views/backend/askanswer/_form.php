<?php
    /* @var $this AskanswerController */
    /* @var $model AskAnswer */
    /* @var $form BsActiveForm */
?>

<div class="form form-structure">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
        'id' => 'askanswer_form-form',
        'enableAjaxValidation' => false,
        )
    );

    echo $form->errorSummary($model);
?>

	<div class="form-group row date-info">
        <div class="col-xs-3">
            <div class="label-block"><?php echo $form->labelEx($model,'time'); ?>:</div>
<?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'model' => $model,
                    'attribute' => 'time',
                    'language' => 'ru',
                    'options' => array(
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                        'value' => (!empty($model->time)) ? date("d.m.Y", $model->time) : date("d.m.Y", time()),
                    ),
                )
            );

            echo $form->error($model,'time');
?>
        </div>
        <div class="col-xs-5 col-xs-offset-4 user-info">
            <div class="label-block"><?php echo $form->labelEx($model, 'author_id'); ?></div>
            <?php echo $form->dropDownList($model, 'author_id', Users::getUserList(array(1, 4)), array('empty' => 'Администратор')); ?>
            <?php echo $form->error($model, 'author_id'); ?>
        </div>
    </div>

	<div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model, 'title'); ?>:</div>
        <div>
<?php
            $this->widget('application.widgets.ImperaviRedactorWidget',
                array(
                    'model' => $model,
                    'attribute' => 'title',
                    'plugins' => array(
                        'imagemanager' => array(
                            'js' => array('imagemanager.js',),
                        ),
                        'filemanager' => array(
                            'js' => array('filemanager.js',),
                        ),
                        'fullscreen' => array(
                            'js' => array('fullscreen.js'),
                        ),
                        'table' => array(
                            'js' => array('table.js'),
                        ),
                    ),
                    'options' => array(
                        'lang' => Yii::app()->language,
                        'imageUpload' => $this->createUrl('admin/imageImperaviUpload'),
                        'imageManagerJson' => $this->createUrl('admin/imageImperaviJson'),
                        'fileUpload' => $this->createUrl('admin/fileImperaviUpload'),
                        'fileManagerJson' => $this->createUrl('admin/fileImperaviJson'),
                        'uploadFileFields' => array(
                            'name' => '#redactor-filename'
                        ),
                        'changeCallback' => 'js:function()
                        {
                            viewSubmitButton(this.$element[0]);
                        }',
                        'buttonSource' => true,
                    ),
                )
            );

            echo $form->error($model, 'title');
?>
        </div>
    </div>

	<div class="form-group">
        <div class="label-block">
        	<?php echo $form->labelEx($model, 'text'); ?>:
        	<label class="checkbox-active <?php echo ($model->answer_ok == 1) ? 'active' : '' ;?>"></label>
        	<input type="hidden" name="answer_ok" value="<?php echo ($model->answer_ok == 1) ? '1' : '0' ;?>">
        </div>
        <div>
<?php
            $this->widget('application.widgets.ImperaviRedactorWidget',
                array(
                    'model' => $model,
                    'attribute' => 'text',
                    'plugins' => array(
                        'imagemanager' => array(
                            'js' => array('imagemanager.js',),
                        ),
                        'filemanager' => array(
                            'js' => array('filemanager.js',),
                        ),
                        'fullscreen' => array(
                            'js' => array('fullscreen.js'),
                        ),
                        'table' => array(
                            'js' => array('table.js'),
                        ),
                    ),
                    'options' => array(
                        'lang' => Yii::app()->language,
                        'imageUpload' => $this->createUrl('admin/imageImperaviUpload'),
                        'imageManagerJson' => $this->createUrl('admin/imageImperaviJson'),
                        'fileUpload' => $this->createUrl('admin/fileImperaviUpload'),
                        'fileManagerJson' => $this->createUrl('admin/fileImperaviJson'),
                        'uploadFileFields' => array(
                            'name' => '#redactor-filename'
                        ),
                        'changeCallback' => 'js:function()
                        {
                            viewSubmitButton(this.$element[0]);
                        }',
                        'buttonSource' => true,
                    ),
                )
            );

            echo $form->error($model,'text');
?>
        </div>
    </div>

    <div class="form-group url-answer">
        <div class="label-block">URL:</div>
        <?php echo CHtml::link($this->finfUrlForItem($model->parent_id, $model->name), $this->finfUrlForItem($model->parent_id, $model->name)); ?>
    </div>

    <div class="form-group"><div class="seo-title"><?php echo Yii::t('app', 'Seo tags'); ?></div></div>

    <div class="form-group seo-text">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_title'); ?>:
            <div>Осталось символов: <span><?php echo 255-strlen($model->seo_title); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_title'); ?>
        <?php echo $form->error($model, 'seo_title'); ?>
    </div>

    <div class="form-group seo-text">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_keywords'); ?>:
            <div>Осталось символов: <span><?php echo 255-strlen($model->seo_keywords); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_keywords'); ?>
        <?php echo $form->error($model, 'seo_keywords'); ?>
    </div>

    <div class="form-group seo-text">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_description'); ?>:
            <div>Осталось символов: <span><?php echo 255-strlen($model->seo_description); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_description'); ?>
        <?php echo $form->error($model, 'seo_description'); ?>
    </div>

	<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app', 'Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
	</div>

    <?php $this->endWidget(); ?>

</div>

<?php
    $cs = Yii::app()->getClientScript();

    $checkbox = "
        $('label.checkbox-active').click(function()
        {
            if($(this).hasClass('active'))
            {
                $(this).removeClass('active');
                $(this).next().attr('value',0);
            }
            else
            {
                $(this).addClass('active');
                $(this).next().attr('value',1);
            }
        });
    ";

    $cs->registerPackage('jquery')->registerScript('sub_forms', $checkbox);
?>