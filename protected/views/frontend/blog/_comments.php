<div class="row comments">
    <?php if(!Yii::app()->user->isGuest || (Yii::app()->user->isGuest && $this->setting['show_comment'] == 0)): ?>
<h3 class="col-md-12">
    Комментарии (<span><?php echo Comments::getCountCommentForPost($model->id, $this->module_id); ?></span>)
</h3>

<div class="col-md-12">
<ul class="media-list">
    <?php echo Comments::getComments(0, $model->id, $this->module_id); ?>
</ul>
</div>
    <?php endif; ?>
<div class="col-md-12">
    <?php
    if (Yii::app()->user->isGuest && $this->setting['comment_dont_registre']==0) {
        echo '<h4>Чтобы оставить свой комментарий Вы ' . CHtml::link('зарегистрироваться', array('user/register')) . ' на сайте.</h4>
        <h4>Если Вы уже зарегистрированный пользователь, то ' . CHtml::link('авторизуйтесь', array('client/loginUser')) . '.</h4>';
    } else {
        ?>
        <?php $form=$this->beginWidget('BsActiveForm', array(
            'htmlOptions'=>array(
                'id'=>'comment-form',
                'role'=>'form',
            ),
            'action'=>$this->createUrl('blog/comment'),
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
        )); ?>
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <h4>Оставьте свой комментарий</h4>
                </label>
                <?php echo $form->textArea($comment, 'text', array('placeholder'=>'Текст комментария', 'class'=>'form-control')); ?>
                <?php echo $form->error($comment, 'text'); ?>

                <?php echo BsHtml::hiddenField('post_id', $model->id); ?>
                <?php echo BsHtml::hiddenField('parent_id', 0); ?>

                <?php
                    if(Yii::app()->user->isGuest && $this->setting['comment_dont_registre']==1)
                    {
                        echo '<div class="row col-xs-5 guest-comment-create">';

                        echo $form->textField($comment, 'name', array('placeholder'=>'Ваш никнейм', 'class'=>'form-control'));
                        echo $form->error($comment, 'name');

                        echo $form->textField($comment, 'email', array('placeholder'=>'Ваш e-mail', 'class'=>'form-control'));
                        echo $form->error($comment, 'email');

                        $this->widget('CMaskedTextField', array(
                            'model' => $comment,
                            'attribute' => 'phone',
                            'mask' => Yii::app()->params['phone']['mask'],
                            'htmlOptions'=>array(
                                'placeholder'=>'Ваш номер телефона',
                                'class'=>'form-control',
                            )
                        ));
                        echo $form->error($comment, 'phone');

                        echo '</div>';
                        echo '<div class="clearfix"></div>';
                    }
                ?>
            </div>
        <?php echo BsHtml::ajaxSubmitButton(Yii::t('app','Отправить'), $this->createUrl('blog/comment'), array(
                'dataType'=>'json',
                'type'=>'POST',
                'success'=>'function(data)
                                    {
                                      if(data.status=="success")
                                      {
                                        $("#comment-form")[0].reset();

                                        var value = $("input[type=hidden]#parent_id").val();

                                        if(value!=0)
                                            $(".comment .links a#"+value).parents(".media-body:first").append(data.comment);
                                        else
                                            $(".media-list").append(data.comment);

                                        $("input[type=hidden]#parent_id").val(0);
                                        $(".comment .links a").on("click", function(){
                                            commentCreate($(this));
                                        });

                                        $(".media .exclamation span").on("click", function(){
                                            complaintCreate($(this));
                                        });

                                        //        добавление комментариев в избранное
                                        $(".blog .posts .comments .media-list .media-body .comment .media-heading .star span").on("click", function(){
                                            createFavourite($(this));
                                        });

                                        if(data.comment != "")
                                        {
                                            var count = parseInt($(".row.comments h3 span").text())+1;
                                            $(".row.comments h3 span").text(count);
                                        }

                                        //        рейтинг комментариев
                                        $(".media .media-body .rating span.fa-plus-square").on("click", function(){
                                            ratingComment($(this), "plus");
                                        });
                                        $(".media .media-body .rating span.fa-minus-square").on("click", function(){
                                            ratingComment($(this), "minus");
                                        });

                                        $("#modal_comment_send").modal("show");
                                      }
                                      else
                                      {
                                        $.each(data, function(key, val)
                                        {
                                          $("#comment-form").find("#"+key+"_em_").text(val).show();
                                        });
                                      }
                                    }',
            ),
            array('class'=>'btn btn-primary')); ?>
        <?php $this->endWidget(); ?>
    <?php
    }
    ?>
</div>
</div>

<?php
$cs = Yii::app()->getClientScript();

$comment = "
//        добавление комментариев
        $('.comment .links a').on('click', function(){
            commentCreate($(this));
        });

        function commentCreate(obj)
        {
            var value = obj.attr('id');
            $('input[type=hidden]#parent_id').val(value);

            var curPos=$(document).scrollTop();
            var height=$('.blog').height();
            var scrollTime=(height-curPos)/1.73;
            $('body,html').animate({'scrollTop':height},scrollTime);
        }

//        добавление жалобы на комментарии
        $('.media .exclamation span').on('click', function(){
            complaintCreate($(this));
        });

        function complaintCreate(obj)
        {
            var value = obj.parents('.comment:first').find('.links a').attr('id');
            $('#message_comment input[type=hidden]#post_id').val(value);
        }

//        добавление комментариев в избранное
        $('.blog .posts .comments .media-list .media-body .comment .media-heading .star span').on('click', function(){
            createFavourite($(this));
        });

        function createFavourite(obj)
        {
            var post_id = obj.parents('.comment:first').find('.links a').attr('id');
            var module_id = '".Comments::MODULE_ID."';

            var type;

            if(!obj.hasClass('active'))
            {
                obj.addClass('active');
                type = 'create';
            }
            else
            {
                obj.removeClass('active');
                type = 'remove';
            }

            $.ajax({
                type: 'POST',
                data: {post_id:post_id, module_id:module_id, type:type},
                url: '".$this->createUrl('blog/post')."',
                success: function(){
                }
            });
        }

        //        рейтинг комментариев
        $('.media .media-body .rating span.fa-plus-square').on('click', function(){
            ratingComment($(this), 'plus');
        });
        $('.media .media-body .rating span.fa-minus-square').on('click', function(){
            ratingComment($(this), 'minus');
        });

        function ratingComment(obj, type)
        {
            var post_id = obj.parents('.comment:first').find('.links a').attr('id');
            var module_id = '".Comments::MODULE_ID."';

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
                    url: '".$this->createUrl('blog/post')."',
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

$cs->registerPackage('jquery')->registerScript('comment', $comment);
?>