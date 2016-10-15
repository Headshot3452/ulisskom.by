<div class="row post">
    <h2 class="col-md-10">
        <a href="<?php echo $this->createUrl('blog/index').$data->name.'?category_id='.$data->parent_id; ?>">
            <?php echo $data->title; ?>
        </a>
    </h2>

    <div class="col-md-12 breadcr"><span class="fa fa-folder-open"></span>
        <?php echo BlogTree::CreatePathForItemLink($data->id); ?>
    </div>
    <div class="col-md-12 text">
        <?php
            $images = $data->getOneFile();

            if(!empty($images))
            {
                echo CHtml::link(CHtml::image($images, $data->title), $this->createUrl('blog/index').$data->name.'?category_id='.$data->parent_id);
            }
        ?>
        <?php echo $this->Substr($data->text, 450); ?>
    </div>
    <div class="read col-md-12">
        <a href="<?php echo $this->createUrl('blog/index').$data->name.'?category_id='.$data->parent_id;; ?>" class="btn btn-success">Читать дальше</a>
    </div>
    <div class="labels col-md-12">
        <span class="fa fa-tag"></span>
        <?php
            foreach(TagItems::getTagsForItem($data->id, $this->module_id) as $value)
            {
                echo '<a href="'.$this->createUrl('blog/index').'?tag_id='.$value->tag['id'].$category.$prev.'">'.$value->tag['title'].'</a>, ';
            }
        ?>
    </div>
    <div class="info col-md-10">
        <div class="col-md-<?php echo (!Yii::app()->user->isGuest)?"12":"8"?> no-padding border">
            <div class="name col-md-<?php echo (!Yii::app()->user->isGuest)?"3":"4"?>">
                <?php
                    $images = $data->user->getOneFile('original');

                    if(!empty($images))
                    {
                        echo CHtml::link(CHtml::image('/'.$images, $data->user->login), $this->createUrl('blog/user', array('id'=>$data->user->id)));
                    }
                    else
                        echo CHtml::link(CHtml::image('/'.Yii::app()->params['noavatar']), $this->createUrl('blog/user', array('id'=>$data->user->id)));
                ?>
                <?php echo CHtml::link($data->user->user_info->getNameUser(), $this->createUrl('blog/user', array('id'=>$data->user->id))); ?>
            </div>
            <div class="time col-md-<?php echo (!Yii::app()->user->isGuest)?"3":"4"?>" title="Дата публикации">
                <span class="fa fa-clock-o"></span>
                <span><?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy HH:MM', $data->time); ?></span>
            </div>
            <div class="view col-md-<?php echo (!Yii::app()->user->isGuest)?"3":"4"?>">
                <span class="fa fa-eye" title="Просмотров"></span> <span><?php echo $data->view; ?></span>
                <span class="fa fa-comments" title="Комментариев"></span><span><?php echo Comments::getCountCommentForPost($data->id, $this->module_id); ?></span>
            </div>
            <?php if(!Yii::app()->user->isGuest){?>
            <div class="star col-md-1">
                <span class="fa fa-star <?php echo (Favourite::checkFavouriteForUser($data->id, $this->module_id)>0)?'active':''; ?>" title="Добавить в избранное"></span>
                <span class="stars" title="Добавили в избранное"><?php echo Favourite::getCountFavouriteForItem($data->id, $this->module_id); ?></span>
            </div>
            <div class="plus col-md-2">
                <?php
                    $rating_type = Rating::checkRatingForUser($data->id, $this->module_id, Yii::app()->user->id);

                    if($rating_type && $rating_type->value>0)
                        echo '<span class="fa fa-plus-square active"></span>';
                    else
                        echo '<span class="fa fa-plus-square"></span>';
                    ?>
                <?php
                    $rating_post = Rating::getRatingForPost($data->id, $this->module_id);

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
                <?php echo BsHtml::hiddenField('post_id', $data->id); ?>
                <?php echo BsHtml::hiddenField('module_id', $this->module_id); ?>
            <?php }?>
        </div>
    </div>
</div>