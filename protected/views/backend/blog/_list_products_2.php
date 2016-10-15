<?php
$this->renderPartial('_filter_tree', array('model'=>$model, 'status'=>$status, 'count_item'=>$count_item, 'typeView'=>$typeView));

$cs=Yii::app()->getClientScript();

$typeCatalog='small feedback-item';

if(empty($typeView))
{
    $typeView = '_product_one_for_list';
}

$this->widget('application.widgets.ProductListViewAdmin', array(
    'id' => 'products-list',
    'htmlOptions'=>array(
        'class'=>$typeCatalog
    ),
    'typeCatalog'=>$typeCatalog,
    'itemView' => $typeView,
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

if($status!=3)
echo CHtml::link('Архив', '?status=3', array('class'=>'btn btn-default btn-archive'));

$this->renderPartial('_modal_windows');
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
            url: '".$this->createUrl('update_status')."',
            data:{status:status, checkbox:post, model:'".get_class($model)."'},
            success:function(data){
                location.href = '';
            }
        });
    });

    $('.complaint img').popover();
    $('.complaint img').on('click', function(){
        $('.complaint img.active').popover('hide');

        if(!$(this).hasClass('active'))
            $(this).addClass('active');
        else
            $(this).removeClass('active');

        $('.complaint img.active').not(this).removeClass('active');
    });

    $('.complaint .complaint-area').hover(function(){
        $(this).find('.remove-complaint').fadeIn(100);
    },function(){
        $(this).find('.remove-complaint').fadeOut(100);
    });

    $('.complaint .remove-complaint').on('click', function(){
        var id = $(this).attr('id');
        $(this).parent().remove();

        $.ajax({
            type: 'POST',
            url: '".$this->createUrl('blog/index')."',
            data: {complaint_id:id},
            success: function(){
                
            }
        });
    });

    $('.tags-blog span').hover(function(){
        $(this).find('i').animate({opacity:1},100);
    },function(){
        $(this).find('i').animate({opacity:0},100);
    });

    $('.tags-blog span i').on('click', function(){
        var id = $(this).attr('id');
        $(this).parent().remove();

        $.ajax({
            type: 'POST',
            data: {tag_id:id},
            success: function(){
                
            }
        });
    });

    $('.blog-comments .block-comment').on('click', function(){
        var status;
        var id = $(this).attr('id');

        var obj = $(this).parent().parent().parent();
        var border = obj.find('.col-xs-1:first');

        if(obj.hasClass('dont-active'))
        {
            obj.removeClass('dont-active');
            $(this).text('Блокировать');

            var value = border.attr('data-status');

            if(value == ".$model::STATUS_DONT_PLACEMENT.")
            {
                value = ".$model::STATUS_PLACEMENT.";
                status = ".$model::STATUS_PLACEMENT.";
            }
            else
            {
                status = border.attr('data-status');
            }

            var color;

            if(value==1)
                color = 'blue';
            if(value==2)
                color = 'orange';
            if(value==4)
                color = 'green';
            if(value==5)
                color = 'red';

            border.css('border-color', color);
        }
        else
        {
            status = ".$model::STATUS_DONT_PLACEMENT.";
            obj.addClass('dont-active');
            $(this).text('Разблокировать');
        }

        $.ajax({
            type: 'POST',
            data: {status:status, id:id},
            success: function(){
            }
        });
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('status',$status);

?>