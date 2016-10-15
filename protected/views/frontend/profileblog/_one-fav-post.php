<div class="col-md-12 my-one-post" id="<?php echo $data->id; ?>">
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
            <div class="preview" onclick="location.href='<?php echo $this->createUrl('blog/index').$data->name.'?category_id='.$data->parent_id; ?>'">
                <?php echo $this->Substr($data->text, 450); ?>
            </div>
            <div class="breadcr">
                <span class="fa fa-folder-open"></span>
                <?php echo BlogTree::CreatePathForItemLink($data->id); ?>
            </div>
        </div>
        <div class="info col-md-10 row">
            <div class="col-md-12 no-padding border">
                <div class="col-md-1 text-center">
                    <span class="exclamation" title="Количество жалоб">
                            <span class="fa fa-exclamation-triangle"></span> 0
                        </span>
                </div>
                <div class="name col-md-3 text-center">
                    <?php
                        $images = $data->user->getOneFile('origin');

                        if(!empty($images))
                        {
                            echo CHtml::link(CHtml::image('/'.$images, $data->user->login), $this->createUrl('blog/user', array('id'=>$data->user->id)));
                        }
                        else
                            echo CHtml::link(CHtml::image('/'.Yii::app()->params['noavatar']), $this->createUrl('blog/user', array('id'=>$data->user->id)));
                    ?>
                    <a href="<?php echo $this->createUrl('blog/user', array('id'=>$data->user->id)); ?>">
                        <?php echo $data->user->user_info->nickname; ?>
                    </a>
                </div>
                <div class="time col-md-3 text-center" title="Дата публикации">
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
                <div class="star col-md-1 text-center">
                    <span class="fa fa-star" title="В избранном"></span>
                    <span class="stars" title="Добавили в избранное">
                        <?php echo Favourite::getCountFavouriteForItem($data->id, $this->module_id); ?>
                    </span>
                </div>
                <div class="plus col-md-1 text-center">
                    <span class="fa fa-thumbs-up"></span>
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