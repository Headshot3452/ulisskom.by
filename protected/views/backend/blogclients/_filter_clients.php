<div class="form top-filter filter-blog filter-client-blog">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'orders-filter',
        'method' => 'get',
        'enableAjaxValidation'=>false,
        'action' => array('blogclients/index'),
    )); ?>

    <div class="row">

    <div class="col-xs-3 search">
        <div class="filter-title">
            Поиск:
        </div>
        <?php echo BsHtml::textField('search', isset($_GET['search'])?$_GET['search']:'', array('class' => 'form-control')); ?>
    </div>

    <div class="col-xs-3 status">
        <div class="filter-title">
            Группы клиентов:
        </div>
        <?php $this->renderPartial('_status', array('model')); ?>
        <?php echo BsHtml::hiddenField('status', (isset($_GET['status']) && !empty($_GET['status']))?$_GET['status']:'', array('class'=>'status-value')); ?>
    </div>

    <div class="col-xs-3 buttons">
        <?php
            echo BsHtml::submitButton('',array('icon'=>BsHtml::GLYPHICON_SEARCH));
        ?>
        <?php if(isset($_GET['status'])):?>
        <a href="<?php echo $this->createUrl('blogclients/index'); ?>" class="btn btn-default">
            <span class="reset-feedback"></span>
        </a>
    <?php endif; ?>
    </div>
    </div>

    <?php echo BsHtml::hiddenField('tree_id', (isset($_GET['tree_id']))?$_GET['tree_id']:''); ?>

    <?php $this->endWidget(); ?>

</div>