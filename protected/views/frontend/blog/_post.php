<div class="row post one-post">
    <h2 class="col-md-10">
        <a href="<?php echo $this->createUrl('blog/index').$model->name.'?category_id='.$model->parent_id; ?>">
            <?php echo $model->title; ?>
        </a>
    </h2>

    <div class="col-md-12 breadcr">
        <span class="fa fa-folder-open"></span>
        <?php echo BlogTree::CreatePathForItemLink($model->id); ?>
    </div>
    <div class="col-md-12 text">
        <?php
            $images = $model->getOneFile();

            if(!empty($images))
            {
                echo CHtml::image($images, $model->title);
            }
        ?>
        <?php echo $model->text; ?>
    </div>
    <div class="labels col-md-12">
        <span class="fa fa-tag"></span>
        <?php
            $category = isset($_GET['category_id'])?'&category_id='.$_GET['category_id']:'';
            $prev = !empty($prev_tree)?'&prev='.$prev_tree->id:'&prev=';

            foreach(TagItems::getTagsForItem($model->id, $this->module_id) as $value)
            {
                echo '<a href="'.$this->createUrl('blog/index').'?tag_id='.$value->tag['id'].$category.$prev.'">'.$value->tag['title'].'</a>, ';
            }
        ?>
    </div>
    <div class="info col-md-11">
        <div class="col-md-<?php echo (!Yii::app()->user->isGuest)?"12":"8"?> no-padding border">
            <div class="name col-md-<?php echo (!Yii::app()->user->isGuest)?"3":"4"?>">
                <?php
                    $images = $model->user->getOneFile('original');

                    if(!empty($images))
                    {
                        echo CHtml::link(CHtml::image('/'.$images, $model->user->login), $this->createUrl('blog/user', array('id'=>$model->user->id)));
                    }
                    else
                        echo CHtml::link(CHtml::image('/'.Yii::app()->params['noavatar']), $this->createUrl('blog/user', array('id'=>$model->user->id)));
                ?>
                <?php echo CHtml::link($model->user->user_info->getNameUser(), $this->createUrl('blog/user', array('id'=>$model->user->id))); ?>
            </div>
            <div class="time col-md-<?php echo (!Yii::app()->user->isGuest)?"3":"4"?>">
                <span class="fa fa-clock-o"></span>
                <span>
                    <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy HH:MM', $model->time); ?>
                </span>
            </div>
            <div class="view col-md-<?php echo (!Yii::app()->user->isGuest)?"2":"4"?>">
                <span class="fa fa-eye" title="Просмотров"></span>
                    <span><?php echo $model->view; ?></span>
                </span>
                <span class="fa fa-comments" title="Комментариев"></span>
                <span>
                    <?php echo Comments::getCountCommentForPost($model->id, $this->module_id); ?>
                </span>
            </div>
            <?php if(!Yii::app()->user->isGuest){?>
            <div class="star col-md-1">
                <span class="fa fa-star <?php echo (Favourite::checkFavouriteForUser($model->id, $this->module_id)>0)?'active':''; ?>" title="Добавить в избранное"></span>
                <span class="stars" title="Добавили в избранное">
                    <?php echo Favourite::getCountFavouriteForItem($model->id, $this->module_id); ?>
                </span>
            </div>
            <div class="exclamation col-md-1">
                <a href="#" data-toggle="modal" data-target="#message_post">
                    <span class="fa fa-exclamation-triangle <?php echo (Complaints::checkComplaitForUser($model->id, $this->module_id))?'active':''; ?>" title="<?php echo (!Yii::app()->user->isGuest)?"Пожаловаться":"Пожаловаться могут только зарегистрированные пользователи"?>"></span>
                </a>
            </div>
            <div class="plus col-md-2">
                <?php
                    $rating_type = Rating::checkRatingForUser($model->id, $this->module_id, Yii::app()->user->id);

                    if($rating_type && $rating_type->value>0)
                        echo '<span class="fa fa-plus-square active"></span>';
                    else
                        echo '<span class="fa fa-plus-square"></span>';
                ?>
                <?php
                    $rating_post = Rating::getRatingForPost($model->id, $this->module_id);

                    if($rating_post!=0): ?>
                        <span class="<?php echo ($rating_post<0)?'bad':'good'; ?>" title="Рейтинг статьи"><?php echo ($rating_post>0)?'+':''; echo $rating_post; ?></span>
                    <?php else: ?>
                        <span title="Рейтинг статьи">0</span>
                    <?php endif; ?>

                    <?php if($rating_type && $rating_type->value<0)
                            echo '<span class="fa fa-minus-square active"></span>';
                        else
                            echo '<span class="fa fa-minus-square"></span>';
                ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();

$favourite_post = "
        var post_id = $('#message_post input[type=hidden]#post_id').val();
        var module_id = $('#message_post input[type=hidden]#module_id').val();

// добавление поста в избранное
        $('.blog .posts .post .info .star span').on('click', function(){
            var type;

            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                $(this).next().text(parseInt($(this).next().text())+1);

                type = 'create';
            }
            else
            {
                $(this).removeClass('active');
                $(this).next().text(parseInt($(this).next().text())-1);

                type = 'remove';
            }

            $.ajax({
                type: 'POST',
                data: {post_id:post_id, module_id:module_id, type:type},
                success: function(){
                }
            });
        });

//        рейтинг поста
        $('.blog .posts .post .info .plus span.fa-plus-square').on('click', function(){
            rating($(this), 'plus');
        });
        $('.blog .posts .post .info .plus span.fa-minus-square').on('click', function(){
            rating($(this), 'minus');
        });

        function rating(obj, type)
        {
            var check;
            var current;
            if(!obj.hasClass('active'))
            {
                if(type == 'plus')
                {
                    current = obj.next().next();
                }
                if(type == 'minus')
                {
                    current = obj.prev().prev();
                }

                if(current.hasClass('active'))
                {
                    current.removeClass('active');
                    check = 'remove';
                }
                else
                {
                    obj.addClass('active');
                    check = 'create';
                }

                $.ajax({
                    type: 'POST',
                    data: {
                            post_id:post_id,
                            module_id:module_id,
                            type:type,
                            check:check
                    },
                    success: function(){
                    }
                });

//                    Установка нового значения рейтинга при нуле
                var parent = obj.parent();
                var children;
                var value;

                if(parent.children('span').hasClass('good'))
                {
                    children = parent.children('.good');

                    if(type=='plus'){
                        value = parseInt(children.text())+1;
                    }
                    else{
                        value = parseInt(children.text())-1;
                    }

                    if(value>0){
                        children.text('+'+value);
                    }
                    else if(value==0)
                            children.text(value);
                        else if(value<0)
                                children.text('-'+value);

                    if(value<=0)
                    {
                        children.removeClass('good');
                    }
                    else if(value<0)
                    {
                        children.addClass('bad');
                    }
                }
                else
                if(parent.children('span').hasClass('bad'))
                {
                    children = parent.children('.bad');

                    if(type=='plus'){
                        value = parseInt(children.text())+1;
                    }
                    else{
                        value = parseInt(children.text())-1;
                    }

                    if(value>0){
                        children.text('+'+value);
                    }
                    else if(value==0)
                            children.text(value);
                        else if(value<0)
                                children.text(value);

                    if(value==0)
                    {
                        children.removeClass('bad');
                    }
                    else if(value>0)
                    {
                        children.addClass('good');
                    }
                }
                else
                {
                    if(parent.find('span').is('span:contains(0)'))
                    {
                        children = parent.find('span:contains(0)');

                        if(parent.find('span:last').hasClass('active'))
                        {
                            children.text('-1');
                            children.addClass('bad');

                        }
                        else if(parent.find('span:first').hasClass('active'))
                        {
                            children.text('+1');
                            children.addClass('good');
                        }
                        else
                        {
                            if(type=='plus')
                            {
                                children.text('+1');
                                children.addClass('good');
                            }
                            else if(type=='minus')
                            {
                                children.text('-1');
                                children.addClass('bad');
                            }
                        }
                    }
                }
                //
            }
        }
//
    ";

$cs->registerPackage('jquery')->registerScript('favourite_post', $favourite_post);
?>

<!-- Modal жалоба на статью -->
<div class="modal fade" id="message_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Отправить жалобу на статью</h4>
            </div>
            <?php $form=$this->beginWidget('BsActiveForm', array(
                'htmlOptions'=>array(
                    'id'=>'complaint-form',
                    'role'=>'form',
                ),
                'action'=>$this->createUrl('blog/complaint'),
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
            )); ?>
            <div class="modal-body">
                <?php echo $form->textArea($complaint, 'text', array('placeholder'=>'', 'rows'=>6, 'class'=>'form-control border')); ?>
                <?php echo $form->error($complaint, 'text'); ?>

                <?php echo BsHtml::hiddenField('post_id', $model->id); ?>
                <?php echo BsHtml::hiddenField('module_id', $this->module_id); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <?php echo BsHtml::ajaxSubmitButton(Yii::t('app','Send complaint'), $this->createUrl('blog/complaint'), array(
                        'dataType'=>'json',
                        'type'=>'POST',
                        'success'=>'function(data)
                                    {
                                      if(data.status=="success")
                                      {
                                        $("#message_post").modal("hide");
                                        $("#complaint-form")[0].reset();

                                        $(".blog .posts .post .info .exclamation span.fa").addClass("active");

                                        $("#modal_complaint").modal("show");
                                      }
                                      else
                                      {
                                        $.each(data, function(key, val)
                                        {
                                          $("#complaint-form").find("#"+key+"_em_").text(val).show();
                                        });
                                      }
                                    }',
                    ),
                    array('class'=>'btn btn-primary')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<?php echo $this->renderPartial('_modal_send', array('text'=>'Ваша жалоба отправлена.', 'id'=>'modal_complaint')); ?>

<!--Модальные окна для комментариев-->
<?php echo $this->renderPartial('_modal_complaint_comment', array('complaint'=>new Complaints())); ?>

<?php echo $this->renderPartial('_modal_send', array('text'=>'Ваш комментарий отправлен.', 'id'=>'modal_comment_send')); ?>