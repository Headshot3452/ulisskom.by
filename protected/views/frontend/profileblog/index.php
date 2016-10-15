<div class="row profileblog">
    <h2 class="col-md-12">Мои посты</h2>

    <div class="col-md-12">
        <div class="dropdown status-blog">
            <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
                <?php echo isset($_GET['status'])?Blog::getStatus($_GET['status']):'Все посты'; ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo $this->createUrl('profileblog/index'); ?>">Все посты</a></li>
                <li><a href="<?php echo $this->createUrl('profileblog/index').'?status='.Blog::STATUS_NEW; ?>">Новые</a></li>
                <li><a href="<?php echo $this->createUrl('profileblog/index').'?status='.Blog::STATUS_MODERETION; ?>">На модерации</a></li>
                <li><a href="<?php echo $this->createUrl('profileblog/index').'?status='.Blog::STATUS_DONT_PLACEMENT; ?>">Отклоненные</a></li>
                <li><a href="<?php echo $this->createUrl('profileblog/index').'?status='.Blog::STATUS_PLACEMENT; ?>">Опубликованные</a></li>
            </ul>
        </div>
        <a href="<?php echo $this->createUrl('profileblog/createpost'); ?>" class="btn btn-primary pull-right"><span class="fa fa-plus"></span> Добавить пост</a>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 posts">
        <div class="">
            <?php
            $this->widget('bootstrap.widgets.BsListView',array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_my-one-post',
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
        </div>
    </div>
</div>

<?php

$cs = Yii::app()->getClientScript();
$status_dropdown = "
            $('.status span').tooltip();
            $('.status span.fa-exclamation-triangle').popover()

            $('.dropdown.status-blog li a').on('click', function(){
                $('.dropdown.status-blog button').html($(this).html()+'<span class=\"caret\"></span>');
            });
        ";
$cs->registerScript("status_dropdown", $status_dropdown);