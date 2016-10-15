<div class="col-md-12 my-one-post">
    <div class="">
        <div class="pic">
            <?php
                $images = $data->getOneFile();

                if(!empty($images))
                {
                    echo CHtml::image($images, $data->title);
                }
                else
                {
                    echo CHtml::image('/'.Yii::app()->params['noimage'], $data->title);
                }
            ?>
        </div>

        <div class="col-md-11 text">
            <div class="preview" onclick="location.href='<?php echo $this->createUrl('profileblog/createpost', array('id'=>$data->id)); ?>'">
                <?php echo $this->Substr($data->text, 450); ?>
            </div>
            <div class="breadcr">
                <span class="fa fa-folder-open"></span>
                <?php echo BlogTree::CreatePathForItemLink($data->id); ?>
            </div>
        </div>

        <div class="col-md-1 status text-center">
            <?php
                switch($data->status)
                {
                    case Blog::STATUS_NEW: echo '<span class="fa fa-plus-circle fa-3x" title="Новый" data-toggle="tooltip" data-placement="top"></span>'; break;
                    case Blog::STATUS_MODERETION: echo '<span class="fa-stack fa-lg" title="На модерации" data-toggle="tooltip" data-placement="top">
                                                            <span class="fa fa-circle fa-stack-2x"></span>
                                                           <span class="fa fa-refresh fa-stack-1x fa-inverse"></span>
                                                       </span>'; break;
                    case Blog::STATUS_ARCHIVE: echo '<span class="fa fa-times-circle fa-3x" title="Заблокирован" data-toggle="tooltip" data-placement="top"></span>'; break;
                    case Blog::STATUS_PLACEMENT: echo '<span class="fa fa-check-circle fa-3x" title="Опубликован" data-toggle="tooltip" data-placement="top"></span>'; break;
                    case Blog::STATUS_DONT_PLACEMENT: echo '<span class="fa fa-times-circle fa-3x" title="Заблокирован" data-toggle="tooltip" data-placement="top"></span>'; break;
                }
            ?>
            <?php if($data->cause)
                echo '<span class="fa fa-exclamation-triangle fa-lg" data-container="body" data-toggle="popover" data-placement="left" data-content="'.$data->cause.'" data-original-title="Причина блокировки"></span>';
            ?>
        </div>

        <div class="info col-md-8 row">
            <div class="col-md-12 no-padding border">
                <?php $count_complaint = count(Complaints::getComplaintsForPost($data->id, $this->module_id)); ?>

                <div class="exclamation col-md-1 text-center <?php echo ($count_complaint>0)?'isset':''; ?>">
                    <span class="fa fa-exclamation-triangle" title="Жалобы"></span>
                    <?php echo $count_complaint; ?>
                </div>

                <div class="time col-md-4 text-center" title="Дата публикации">
                    <span class="fa fa-clock-o"></span>
                    <span>
                        <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:MM', $data->time); ?>
                    </span>
                </div>

                <div class="view col-md-3 text-center">
                    <span class="fa fa-eye" title="Просмотров"></span>
                    <span><?php echo $data->view; ?></span>

                    <span class="fa fa-comments" title="Комментариев"></span>
                    <span><?php echo Comments::getCountCommentForPost($data->id, $this->module_id); ?></span>
                </div>

                <div class="star col-md-2 text-center">
                    <span class="fa fa-star" title="Добавить в избранное"></span>
                    <span class="stars" title="Добавили в избранное">
                        <?php echo Favourite::getCountFavouriteForItem($data->id, $this->module_id); ?>
                    </span>
                </div>

                <div class="plus col-md-2 text-center">
                    <span class="fa fa-thumbs-up" title="Рейтинг статьи"></span>
                    <?php
                        $rating_post = Rating::getRatingForPost($data->id, $this->module_id);

                        if($rating_post!=0): ?>
                            <span class="<?php echo ($rating_post<0)?'bad':'good'; ?>" title="Рейтинг статьи"><?php echo ($rating_post>0)?'+':''; echo $rating_post; ?></span>
                        <?php else: ?>
                            <span title="Рейтинг статьи">0</span>
                        <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>