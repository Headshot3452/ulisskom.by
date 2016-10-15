<div class="form top-filter filter-blog filter-client-post">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'orders-filter',
        'method' => 'get',
        'enableAjaxValidation'=>false,
        'action' => array('blogclients/index'),
    )); ?>

    <div class="row">

    <div class="col-xs-2 back-menu">
        <?php echo $this->getPageTitleBlockDefault(); ?>
    </div>

    <?php
        $cs = Yii::app()->getClientScript();
        $cs->registerPackage('hint');
        $image = $model->getOneFile('original');
        if (!$image)
        {
            $image = Yii::app()->params['noavatar'];
        }
    ?>
    <div id="user_item_setting"  class="col-xs-4">
        <div class="table-img"><img src="/<?php echo $image ;?>"/></div>
        <div class="number-user">#&nbsp;&nbsp;<?php echo $model->id ;?><span  style="color: <?php echo ($model->status==1)?"#009f00":"#ff0000"; ?>"><?php echo UserInfo::getStatus($model->status); ?></span></div>
        <div class="user">
            <img src="/images/icon-admin/little_user_company.png"/><?php echo $model->user_info->getFullName() ;?>
        </div>
        <div class="mail">
            <img src="/images/icon-admin/little_message_company.png"/><?php echo $model->email ;?>
        </div>
        <div class="phone">
            <img src="/images/icon-admin/little_phone.png"/><?php echo $model->user_info->phone ;?>
        </div>
    </div>

    <div class="col-xs-3 status" style="float: right;">
        <div class="filter-title">
            Группы клиентов:
        </div>
        <div class="dropdown status-feedback status-blog">
            <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
                <?php echo UserInfo::getStatus($model->status); ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a id="1">Хороший клиент</a></li>
                <li><a id="2">Плохой клиент</a></li>
                <li><a id="3">Злой клиент</a></li>
            </ul>
        </div>
        <?php echo BsHtml::hiddenField('status', (isset($_GET['status']) && !empty($_GET['status']))?$_GET['status']:'', array('class'=>'status-value')); ?>
    </div>

    <div class="col-xs-3 buttons">
        <?php
//            echo BsHtml::submitButton('',array('icon'=>BsHtml::GLYPHICON_SEARCH));
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

<?php
$status_blog="
    $('.status-feedback ul a').on('click', function(){
        var value = $(this).attr('id');

        $('.status-feedback button').html($(this).html()+'<span class=\"caret\" style=\"color: #000\"></span>');
        $('.filter-blog .status-value').val(value);

        $.ajax({
            type: 'POST',
            data: {user_id:".$model->id.", status:value},
            success: function(){
                window.location.reload()
            }
        });
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('$status_blog',$status_blog);

?>