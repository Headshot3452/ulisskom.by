<div class="form top-filter filter-blog">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'orders-filter',
        'method' => 'get',
        'enableAjaxValidation'=>false,
        'action' => array('blog/'.Yii::app()->controller->action->id),
    )); ?>

    <div class="row">

    <div class="col-xs-2 back-menu">
        <a href="<?php echo $this->createUrl('admin/siteManagement'); ?>">
            <img src="/images/icon-admin/feedback.png">
        </a>
        <?php echo $this->getPageTitleBlockDefault(); ?>
    </div>

    <div class="col-xs-2 search">
        <div class="filter-title">
            Поиск:
        </div>
        <?php echo BsHtml::textField('search', isset($_GET['search'])?$_GET['search']:'', array('class' => 'form-control')); ?>
    </div>

    <div class="col-xs-3 status">
        <div class="filter-title">
            Статус:
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
        <a href="<?php echo $this->createUrl('blog/'.Yii::app()->controller->action->id); ?>" class="btn btn-default">
            <span class="reset-feedback"></span>
        </a>
    <?php endif; ?>
        <a href="<?php echo $this->createUrl('settings'); ?>" class="btn btn-default btn-setting">
            <span class="icon-admin-settings"></span>
        </a>
    </div>
    </div>

    <?php echo BsHtml::hiddenField('tree_id', (isset($_GET['tree_id']))?$_GET['tree_id']:''); ?>

    <?php $this->endWidget(); ?>

</div>