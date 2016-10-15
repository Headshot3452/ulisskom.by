<?php
$header  = '<div class="buttons_group spisok-question">';
$header .= '<div class="btn-group checkbox">
                    <button type="button" class="btn checkbox-action">-</button>
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#modal_new" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В обработке</a></li>
                        <li><a href="#modal_answer" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Ответили</a></li>
                        <li><a href="#modal_archive" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В архив</a></li>
                        <li><a href="#modal_delete" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Удалить</a></li>
                    </ul>';
$header .=  ($status!=3)?'<div class="spisok">Список вопросов темы</div>':'<div class="spisok">Архив</div>';
$header .= '</div>
            </div>';

$header .= '<div class="dropdown-question">
              '.BsHtml::dropDownList('tree_id','tree_id', FeedbackTree::getAllTreeFilter(), array('empty' => 'Все темы вопросов', 'options' => array(Yii::app()->request->getParam('tree_id') => array('selected' => true)))).'
            </div>';

$header .= $this->UrlTopPagination($count_item, 'Feedback');

$header .=  '<div class="row title-feedback">
                <div class="col-xs-1">
                    <span>№ / Дата</span>
                </div>
                <div class="col-xs-3">
                    <span>Клиент</span>
                </div>
                <div class="col-xs-2">
                    <span>Тема</span>
                </div>
                <div class="col-xs-5">
                    <span>Вопрос</span>
                </div>
            </div>';

$cs=Yii::app()->getClientScript();

$typeCatalog='small feedback-item';

$this->widget('application.widgets.ProductListViewAdmin', array(
    'id' => 'products-list',
    'htmlOptions'=>array(
        'class'=>$typeCatalog
    ),
    'typeCatalog'=>$typeCatalog,
    'itemView' => '_product_one_for_list',
    'dataProvider' => $dataProducts,
    'ajaxUpdate' => false,
    'template' =>  $header."{counter}\n{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center pager-item\">{pager}</div></div>",
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

<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip();
</script>

<?php
$status="
    $('.one_item').on('click', function(event){
        if(event.target.tagName == 'DIV' || event.target.tagName == 'SPAN')
        {
            var id = $(this).attr('id');

            window.location.href = '".$this->createUrl('feedback/update')."?id='+id;
        }
    });

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
            data:{status:status, checkbox:post},
            success:function(data){
                location.href = '';
            }
        });
    });

    $('.dropdown-question select').on('change', function(){
        var value = $(this).val();

        if(value!='')
            $('input#tree_id').val(value);
        else
            $('input#tree_id').val('');
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('status',$status);

?>