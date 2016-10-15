<div class="row profileblog">
    <h2 class="col-md-12">Избранные посты</h2>
    <div class="clearfix"></div>

    <div class="col-md-12 posts fav">
        <div class="row favorite">
            <div class="col-md-12">
            <?php
            $this->widget('bootstrap.widgets.BsListView',array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_one-fav-post',
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
</div>

<?php

$cs = Yii::app()->getClientScript();

$favourite_post = "
        $('.favorite .my-one-post .star span.fa-star').on('click', function(){
            var post_id = $(this).parents('.my-one-post:first').attr('id')
            var module_id = '".$this->module_id."';

            $(this).parents('.my-one-post:first').remove();

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