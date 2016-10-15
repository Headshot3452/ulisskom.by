<div class="ask-answer">
    <div class="container">
        <div class='row'>
            <div class="col-md-8">
                <h1>
                    Вопрос-ответ
                </h1>

                <div class="row">
<?php
                    if($popular)
                    {
?>
                        <div class="col-md-12 ask-group">
                            <h3>Популярные вопросы и ответы</h3>

                            <div class="asks">
<?php
                                $this->widget('bootstrap.widgets.BsListView',array(
                                    'dataProvider'=>$popular,
                                    'itemView'=>'_item_popular',
                                    'ajaxUpdate'=>false,
                                    'emptyText'=>'<h5>Пока нет ни одного вопроса.</h5>',
                                    'template'=>'{items}<div class=\"row text-left\">{pager}</div>',
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
                    <?php } ?>
                    <div class="col-md-12 ask-group">
                        <h3>Последние добавленные вопросы и ответы</h3>

                        <div class="asks">
                            <?php
                            $this->widget('bootstrap.widgets.BsListView',array(
                                'dataProvider'=>$dataProvider,
                                'itemView'=>'_item',
                                'ajaxUpdate'=>false,
                                'emptyText'=>'<h5>Пока нет ни одного вопроса.</h5>',
                                'template'=>'{items}<div class=\"row text-left\">{pager}</div>',
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

            <div class="col-md-4 side-bar">
                <?php $this->renderPartial('_side_bar')?>
            </div>

        </div>
    </div>
</div>