<div class="media <?php echo ($model->status == Comments::STATUS_DONT_PLACEMENT)?'blocked':''; ?>">
    <?php
    if (isset($model->user))
    {
        $images = $model->user->getOneFile('original');

        if (!empty($images)) {
            echo CHtml::link(CHtml::image('/' . $images, $model->user->login, array('class' => 'media-object')), $this->createUrl('blog/user', array('id' => $model->user->id)), array('class' => 'pull-left'));
        } else
            echo CHtml::link(CHtml::image('/' . Yii::app()->params['noavatar'], '', array('class' => 'media-object')), $this->createUrl('blog/user', array('id' => $model->user->id)), array('class' => 'pull-left'));
    }
    else
    {
        echo CHtml::image('/' . Yii::app()->params['noavatar'], '', array('class' => 'media-object guest-comment'));
    }
    ?>
<div class="media-body">

    <div class="comment">
        <div class="media-heading">
            <?php echo isset($model->user)?CHtml::link($model->user->user_info->getNameUser(), $this->createUrl('blog/user', array('id'=>$model->user->id)), array('class'=>'name')):'<span class="name">'.$model->name.'</span>'; ?>
                <span class="time">
                    <span>
                        <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy HH:MM', $model->time); ?>
                    </span>
                </span>
            <?php if (!Yii::app()->user->isGuest) { ?>
                <span class="exclamation">
                    <span class="fa fa-exclamation-triangle <?php echo (Complaints::checkComplaitForUser($model->id, Comments::MODULE_ID))?'active':''; ?>" data-toggle="modal" data-target="#message_comment" title="Пожаловаться"></span>
                </span>
                <span class="star">
                    <span class="fa fa-star <?php echo (Favourite::getCountFavouriteForItem($model->id, Comments::MODULE_ID)>0)?'active':''; ?>" title="Добавить в избранное"></span>
                </span>
            <?php } ?>
        </div>
        <?php if($model->status != Comments::STATUS_DONT_PLACEMENT): ?>
            <div class="comment">
                <?php echo $model->text; ?>
            </div>
            <div class="links">
                <a id="<?php echo $model->id; ?>">Ответить</a>
            </div>
        <?php else: ?>
            <div class="blocked-text">
                Заблокировано администрацией сайта.
            </div>
        <?php endif; ?>
        <div class="rating">
            <?php
                $rating_type = Rating::checkRatingForUser($model->id, Comments::MODULE_ID, Yii::app()->user->id);

                if($rating_type && $rating_type->value>0)
                    echo '<span class="fa fa-plus-square active"></span>';
                else
                    echo '<span class="fa fa-plus-square"></span>';
            ?>
            <?php
                $rating_post = Rating::getRatingForPost($model->id, Comments::MODULE_ID);

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
    <?php echo (isset($post_id) && isset($module_id))?Comments::getComments($model->id, $post_id, $module_id):''; ?>
</div>
</div>