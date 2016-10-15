<div class="row one-comment" id="<?php echo $data->id; ?>">
    <div class="col-md-12 post-info">
        <span class="post-name">
            <?php
                $post = Blog::getPostForComment($data->post_id);
                echo '<a href="'.$this->createUrl('blog/index').$post->name.'?category_id='.$post->parent_id.'">'.$post->name.'</a>';
            ?>
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
        if(isset($data->user))
        {
            $images = $data->user->getOneFile('original');

            if (!empty($images)) {
                echo CHtml::image('/' . $images, $data->user->login, array('class' => 'pic'));
            } else
                echo CHtml::image('/' . Yii::app()->params['noavatar'], '', array('class' => 'pic'));
        }
        else
        {
            echo CHtml::image('/' . Yii::app()->params['noavatar'], '', array('class' => 'pic'));
        }
        ?>

        <div class="col-md-11 info">
            <div class="">
                <span class="name">
                    <?php echo isset($data->user)?$data->user->user_info->nickname:$data->name; ?>
                </span>
                <span class="date">
                    <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:MM', $data->time); ?>
                </span>
            </div>
            <div class="text">
                <p><?php echo $data->text; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-10">
        <div class="col-md-4 no-padding border">
            <div class="col-md-4 text-center">
                <?php $count_complaint = count(Complaints::getComplaintsForPost($data->id, Comments::MODULE_ID)); ?>
                <span class="exclamation <?php echo ($count_complaint>0)?'isset':''; ?>">
                    <span class="fa fa-exclamation-triangle"  data-toggle="modal" data-target="#message_comment"></span>
                    <span><?php echo $count_complaint; ?></span>
                </span>
            </div>
            <div class="star col-md-4 text-center">
                <span class="fa fa-star" title="В избранном"></span>
                <span class="stars" title="Добавили в избранное">
                    <?php echo Favourite::getCountFavouriteForItem($data->id, Comments::MODULE_ID); ?>
                </span>
            </div>
            <div class="plus col-md-4 text-center" title="Рейтинг комментария">
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