<?php
$model_name = get_class($model);
$data=array();

foreach($this->getCategories() as $category)
{
    if ($category['id']!=$model->id)
    {
        $data[$category['id']]=str_repeat('<i class="fa fa-circle"></i>',$category['level']).' '.$category['title'];
    }
}

$str_tree='';
foreach($data as $key=>$item)
{
    $str_tree.='<li><a id="'.$key.'">'.$item.'</a></li>';
}

$value_action = ($model_name=='Blog')?'Все категории постов':'Все категории комментариев';
$value_tree = (isset($_GET['tree_id']) && !empty($_GET['tree_id']))?$data[$_GET['tree_id']]:$value_action;

$page_name = ($model_name=='Blog')?'Посты':'Комментарии';
?>

<?php
$this->header .= '<div class="buttons_group spisok-question">';
$this->header .= '<div class="btn-group checkbox">
                    <button type="button" class="btn checkbox-action">-</button>
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#modal_answer" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">На модерации</a></li>
                        <li><a href="#modal_new" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Разместить</a></li>
                        <li><a href="#modal_archive" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В архив</a></li>
                    </ul>';
$this->header .=  ($status!=3)?'<div class="spisok">'.$page_name.'</div>':'<div class="spisok">Архив</div>';
$this->header .= '</div>
            </div>';

$this->header .= '<div class="dropdown tree-blog">
                    <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
                        '.$value_tree.'
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        '.$str_tree.'
                    </ul>
                  </div>';

$this->header .= '<span class="count-result">( '.$count_item.' )</span>';

$this->header .= $this->UrlTopPagination($count_item, $model_name);

if($typeView!='_product_one_for_comments')
$this->header .=  '<div class="row title-feedback">
                <div class="col-xs-1">
                    <span># / Дата</span>
                </div>
                <div class="col-xs-2">
                    <span>Клиент</span>
                </div>
                <div class="col-xs-3">
                    <span>Категории / метки</span>
                </div>
                <div class="col-xs-5">
                    <span>Заголовок поста</span>
                </div>
            </div>';

$tree_id="
    $('.dropdown.tree-blog li a').on('click', function(){
        var value = $(this).attr('id');

        $('.dropdown.tree-blog button').html($(this).html()+'<span class=\"caret\"></span>');
        $('.dropdown.tree-blog button i').css('color', '#0849e1');

        if(value!='')
            $('input#tree_id').val(value);
        else
            $('input#tree_id').val('');
    });

    $('.dropdown.tree-blog li a').hover(function(){
        $(this).find('i').css('color', '#fff');
    },
    function(){
        $(this).find('i').css('color', '#0849e1');
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('$tree_id',$tree_id);

?>