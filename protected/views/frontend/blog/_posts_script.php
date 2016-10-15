<?php

$cs = Yii::app()->getClientScript();

$favourite_post = "
        $('.blog .posts .post .info .star span').on('click', function(){
            var post_id = $(this).parents('.info:first').find('input[type=hidden]#post_id').val();
            var module_id = $(this).parents('.info:first').find('input[type=hidden]#module_id').val();

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
                url: '".$this->createUrl('blog/post')."',
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
            var post_id = obj.parents('.info:first').find('input[type=hidden]#post_id').val();
            var module_id = obj.parents('.info:first').find('input[type=hidden]#module_id').val();

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
                            check:check,
                            model:'blog'
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
