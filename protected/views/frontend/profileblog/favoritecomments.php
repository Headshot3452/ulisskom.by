<div class="row profileblog">
    <h2 class="col-md-12">Избранные комментарии</h2>
    <div class="clearfix"></div>

    <div class="col-md-12 comments fav">
        <div class="row favorite">
            <div class="col-md-12">
            <?php
            $this->widget('bootstrap.widgets.BsListView',array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_one-fav-comment',
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

<?php

$cs = Yii::app()->getClientScript();

$favourite_post = "
        $('.favorite .one-comment .star span.fa-star').on('click', function(){
            var post_id = $(this).parents('.one-comment:first').attr('id')
            var module_id = '".Comments::MODULE_ID."';

            $(this).parents('.one-comment:first').remove();

            $.ajax({
                type: 'POST',
                url: '".$this->createUrl('blog/post')."',
                data: {post_id:post_id, module_id:module_id, type:'remove'},
                success: function(){
                }
            });
        });
    ";

$cs->registerPackage('jquery')->registerScript('favourite_post', $favourite_post);