<!--скрипт для комментариев расположеных на странице профиля пользователя-->
<?php

$cs = Yii::app()->getClientScript();

$comment = "
//        добавление жалобы на комментарии
        $('.one-comment .exclamation span').on('click', function(){
            complaintCreate($(this));
        });

        function complaintCreate(obj)
        {
            var value = obj.parents('.one-comment:first').attr('id');
            $('#message_comment input[type=hidden]#post_id').val(value);

            obj.addClass('active');
        }

        //        рейтинг комментариев
        $('.one-comment span.fa-plus-square').on('click', function(){
            ratingComment($(this), 'plus');
        });
        $('.one-comment span.fa-minus-square').on('click', function(){
            ratingComment($(this), 'minus');
        });

        function ratingComment(obj, type)
        {
            var post_id = obj.parents('.one-comment:first').attr('id');
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