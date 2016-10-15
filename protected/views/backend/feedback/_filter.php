<div class="form top-filter top-filter-feedback">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'orders-filter',
        'method' => 'get',
        'enableAjaxValidation'=>false,
        'action' => array('feedback/index'),
    )); ?>

    <div class="row">

    <div class="col-xs-4 back-menu">
        <a href="<?php echo $this->createUrl('admin/siteManagement'); ?>">
            <img src="/images/icon-admin/feedback.png">
        </a>
        <?php echo $this->getPageTitleBlockDefault(); ?>
    </div>

    <div class="col-xs-3 status">
        <div class="filter-title">
            Статус:
        </div>
        <?php echo BsHtml::dropDownList('status','status', array('0'=>'Все', '1'=>'В обработке', '2'=>'Ответили', '3'=>'В архив'), array('options' => array(Yii::app()->request->getParam('status') => array('selected' => true)))); ?>
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
        <a href="<?php echo $this->createUrl('index'); ?>" class="btn btn-default">
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