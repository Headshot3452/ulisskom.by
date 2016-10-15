<div class="tags">
<span class="title-tags">Метки</span>
<?php

$this->widget('application.widgets.ProductListViewAdmin', array(
'id' => 'products-list',
'itemView' => '_item',
'dataProvider' => $dataProvider,
'ajaxUpdate' => false,
'template' =>  "{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center pager-item\">{pager}</div></div>",
'pager' => array(
'class' => 'bootstrap.widgets.BsPager',
'firstPageLabel' => '<<',
'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
'lastPageLabel' => '>>',
'hideFirstAndLast'=>true,
)
));

$tags = "
        $('.remove-tag').on('click', function(){
            var id = $(this).attr('id');
            $(this).parent().parent().remove();

            $.ajax({
                type: 'POST',
                data: {id:id},
                success: function(){
                }
            });
        });

        $('.tag-item button').on('click', function(){
            var id = $(this).attr('id');

            var input = $(this).prev().prev();
            var span = $(this).prev().prev().prev();
            var parent = $(this).parent();

            if(!input.is(':visible'))
            {
                input.show();
                span.hide();
                parent.addClass('active');
            }
            else
            {
                input.hide();
                span.show();
                parent.removeClass('active');

                var title = input.val();
                span.text(title);

                $.ajax({
                    type: 'POST',
                    data: {change_id:id, title:title},
                    success: function(){
                    }
                });
            }
        });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('tags',$tags);

?>
</div>