<div class="col-md-12">
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
                $images = $data->user->getOneFile('original');

                if(!empty($images))
                {
                    echo CHtml::image('/'.$images, $data->user->login, array('class'=>'pic'));
                }
                else
                    echo CHtml::image('/'.Yii::app()->params['noavatar'], '', array('class'=>'pic'));
            ?>
            <div class="col-md-12 info">
                <div class="">
                    <span class="name">
                        <?php echo $data->user->user_info->nickname; ?>
                    </span>
                    <span class="date">
                        <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy HH:MM', $data->time); ?>
                    </span>
                </div>
                <div class="text">
                    <p><?php echo $data->text; ?></p>
                </div>
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
                <div class="plus col-md-8 text-center">
                    <?php
                        $rating_type = Rating::checkRatingForUser($data->id, Comments::MODULE_ID, Yii::app()->user->id);

                        if($rating_type && $rating_type->value>0)
                            echo '<span class="fa fa-plus-square active"></span>';
                        else
                            echo '<span class="fa fa-plus-square"></span>';
                        ?>
                    <?php
                        $rating_post = Rating::getRatingForPost($data->id, Comments::MODULE_ID);

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
            </div>
        </div>
    </div>
</div>