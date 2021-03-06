<div class="row profileblog">
    <h2 class="col-md-12">Я читаю</h2>
    <div class="clearfix"></div>

    <?php if(count($dataProvider_new->getData())>0): ?>
    <!--    новые читатели-->
    <div class="col-md-12 new readerships border-bottom">
        <h5>Новые посты</h5>
        <div class="">
            <?php
            $this->widget('bootstrap.widgets.BsListView',array(
                'dataProvider'=>$dataProvider_new,
                'itemView'=>'_one-read',
                'ajaxUpdate'=>false,
                'emptyText'=>'<h5>Пока нет ни одного читателя.</h5>',
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
    <?php endif; ?>
    <!--читатели-->
    <div class="col-md-12 readerships">
        <div class="">
            <?php
            $this->widget('bootstrap.widgets.BsListView',array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_one-reader',
                'ajaxUpdate'=>false,
                'emptyText'=>'<h5>Пока нет ни одного читателя.</h5>',
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