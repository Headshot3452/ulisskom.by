<?php
$this->renderPartial('_filter_tree_clients', array('model'=>$model, 'count_item'=>$count_item));

$cs=Yii::app()->getClientScript();

$typeCatalog='small feedback-item client-blog-list';

$this->widget('application.widgets.ProductListViewAdmin', array(
    'id' => 'products-list',
    'htmlOptions'=>array(
        'class'=>$typeCatalog
    ),
    'typeCatalog'=>$typeCatalog,
    'itemView' => '_clients_one_for_list',
    'dataProvider' => $dataProducts,
    'ajaxUpdate' => false,
    'template' =>  $this->header."{counter}\n{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center pager-item\">{pager}</div></div>",
    'pager' => array(
        'class' => 'bootstrap.widgets.BsPager',
        'firstPageLabel' => '<<',
        'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
        'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
        'lastPageLabel' => '>>',
        'hideFirstAndLast'=>true,
    ),
    'counter' => $count,
));

$this->renderPartial('_modal_windows_client');
?>

    <form method="POST" class="copy" data-module="feedback">

    </form>

<?php
$status="
    $('button.change_status').on('click', function(){
        var status = $(this).attr('data-status');
        var post = [];

        $('.one_item.feedback').each(function(i){
            if($(this).find('.checkbox').prop('checked')){
                post.push($(this).attr('id'));
            }
        });

        $.ajax({
            type:'POST',
            url: '".$this->createUrl('update_status_client')."',
            data:{status:status, checkbox:post, model:'".get_class($model)."'},
            success:function(data){
                location.href = '';
            }
        });
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('status',$status);

?>