<?php
$cs = Yii::app()->getClientScript();
$header_popovers = '
    $(".status span.fa-exclamation-triangle").popover();
    ';
$cs->registerScript("header_popovers", $header_popovers);
?>
<div class="row profileblog">
    <h2 class="col-md-12">Мои комментарии</h2>
    <div class="clearfix"></div>

    <div class="col-md-12 comments">
        <div class="row">
            <div class="col-md-12">
            <?php
            $this->widget('bootstrap.widgets.BsListView',array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_one-comment',
                'ajaxUpdate'=>false,
                'emptyText'=>'<h5>Пока нет ни одного комментария.</h5>',
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
            </div>
        </div>
    </div>
</div>