<?php
$category = isset($_GET['category_id'])?'&category_id='.$_GET['category_id']:'';
$prev = !empty($prev_tree)?'&prev='.$prev_tree->id:'&prev=';

$this->widget('bootstrap.widgets.BsListView',array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_one-post',
    'viewData'=>array('category'=>$category, 'prev'=>$prev),
    'ajaxUpdate'=>false,
    'emptyText'=>'<h5>Пока нет ни одного поста.</h5>',
    'template'=>'{items}<div class=\"row text-center\">{pager}</div>',
    'pager' => array(
        'class' => 'bootstrap.widgets.BsPager',
        'firstPageLabel' => '<<',
        'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
        'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
        'lastPageLabel' => '>>',
        'hideFirstAndLast'=>true,
    ),
));

?>

<?php echo $this->renderPartial('_posts_script'); ?>