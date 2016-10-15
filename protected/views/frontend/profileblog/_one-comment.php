<div class="row one-comment">
    <div class="col-md-12 post-info">
        <span class="post-name">
            <a href="/blog/post">
                <?php
                    $post = Blog::getPostForComment($data->post_id);
                    echo '<a href="'.$this->createUrl('blog/index').$post->name.'?category_id='.$post->parent_id.'">'.$post->name.'</a>';
                ?>
            </a>
        </span> /
        <span class="author">автор:
            <?php echo '<a href="'.$this->createUrl('blog/user', array('id'=>$post->user_id)).'">'.$post->user->user_info->nickname.'</a>'; ?>
        </span>
        <span class="comments-count">
            <span class="fa fa-comments" title="Комментариев"></span>
            <span><?php echo Comments::getCountCommentForPost($post->id, $this->module_id); ?></span>
        </span>
    </div>
    <div class="col-md-12">
        <?php
            $images = $data->user->getOneFile('original');

            if(!empty($images))
            {
                echo CHtml::image('/'.$images, $data->user->login, array('class'=>'pic'));
            }
            else
                echo CHtml::image('/'.Yii::app()->params['noavatar'], '', array('class'=>'pic'));
        ?>

        <div class="col-md-11 info">
            <div class="">
                <span class="name">
                    <?php echo $data->user->user_info->nickname; ?>
                </span>
                <span class="date">
                    <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:MM', $data->time); ?>
                </span>
            </div>
            <div class="text">
                <p><?php echo $data->text; ?></p>
            </div>
        </div>
        <div class="col-md-1 status text-center">
            <?php
                switch($data->status)
                {
                    case Comments::STATUS_NEW: echo '<span class="fa fa-plus-circle fa-3x" title="Новый" data-toggle="tooltip" data-placement="top"></span>'; break;
                    case Comments::STATUS_MODERETION: echo '<span class="fa-stack fa-lg" title="На модерации" data-toggle="tooltip" data-placement="top">
                                                                <span class="fa fa-circle fa-stack-2x"></span>
                                                               <span class="fa fa-refresh fa-stack-1x fa-inverse"></span>
                                                           </span>'; break;
                    case Comments::STATUS_ARCHIVE: echo '<span class="fa fa-times-circle fa-3x" title="Заблокирован" data-toggle="tooltip" data-placement="top"></span>'; break;
                    case Comments::STATUS_PLACEMENT: echo '<span class="fa fa-check-circle fa-3x" title="Опубликован" data-toggle="tooltip" data-placement="top"></span>'; break;
                    case Comments::STATUS_DONT_PLACEMENT: echo '<span class="fa fa-times-circle fa-3x" title="Заблокирован" data-toggle="tooltip" data-placement="top"></span>'; break;
                }
            ?>
        </div>
    </div>
    <div class="col-md-10">
        <div class="col-md-3 no-padding border">
            <div class="col-md-4 text-center">
                <?php $count_complaint = count(Complaints::getComplaintsForPost($data->id, Comments::MODULE_ID)); ?>
                <span class="exclamation <?php echo ($count_complaint>0)?'isset':''; ?>">
                    <span class="fa fa-exclamation-triangle"  data-toggle="modal" data-target="#message_comment"></span>
                    <span><?php echo $count_complaint; ?></span>
                </span>
            </div>
            <div class="plus col-md-8 text-center" title="Рейтинг комментария">
                <span class="fa fa-thumbs-up"></span>
                <?php
                $rating_post = Rating::getRatingForPost($data->id, Comments::MODULE_ID);

                if($rating_post!=0): ?>
                    <span class="<?php echo ($rating_post<0)?'bad':'good'; ?>" title="Рейтинг статьи"><?php echo ($rating_post>0)?'+':''; echo $rating_post; ?></span>
                <?php else: ?>
                    <span title="Рейтинг статьи">0</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>