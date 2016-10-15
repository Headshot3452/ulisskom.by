<div class="form top-filter filter-blog filter-tags">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'orders-filter',
        'method' => 'get',
        'enableAjaxValidation'=>false,
        'action' => array('tags/'.Yii::app()->controller->action->id),
    )); ?>

    <div class="row">

    <div class="col-xs-2 back-menu">
        <?php echo BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), '/admin/settings').TagsController::getModuleName(),'/admin/settings'); ?>
    </div>

    <div class="col-xs-2 search">
        <div class="filter-title">
            Поиск:
        </div>
        <?php echo BsHtml::textField('search', isset($_GET['search'])?$_GET['search']:'', array('class' => 'form-control')); ?>
    </div>

    <div class="col-xs-3 status">
        <div class="filter-title">
            Сортировка:
        </div>
        <?php $this->renderPartial('_status', array('model')); ?>
        <?php echo BsHtml::hiddenField('status', (isset($_GET['status']) && !empty($_GET['status']))?$_GET['status']:'', array('class'=>'status-value')); ?>
    </div>

    <div class="col-xs-3 period-date">
        <div class="filter-title">
            Период:
        </div>
        <div class="period">
            <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'dd.mm.yy',
                    ),
                    'value'=>Yii::app()->request->getParam('date_from'),
                    'htmlOptions'=>array(
                        'class'=>'from form-control',
                        'name'=>'date_from'
                    ),
                ));
            ?>
            &nbsp;-&nbsp;
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>'dd.mm.yy',
                ),
                'value'=>Yii::app()->request->getParam('date_to'),
                'htmlOptions'=>array(
                    'class'=>'to form-control',
                    'name'=>'date_to'
                ),
            ));
            ?>
        </div>
    </div>

    <div class="col-xs-3 buttons">
        <?php
            echo BsHtml::submitButton('',array('icon'=>BsHtml::GLYPHICON_SEARCH));
        ?>
        <?php if(isset($_GET['status'])):?>
        <a href="<?php echo $this->createUrl('tags/'.Yii::app()->controller->action->id); ?>" class="btn btn-default">
            <span class="reset-feedback"></span>
        </a>
    <?php endif; ?>
    </div>
    </div>

    <?php $this->endWidget(); ?>

</div>