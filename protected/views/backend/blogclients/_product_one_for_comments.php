<li class="one_item feedback blog-comments <?php echo ($data->status == $data::STATUS_DONT_PLACEMENT)?'dont-active':''; ?>" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-1 text-center" data-status="<?php echo $data->status; ?>" style="border-color:<?php echo $data::getColorStatus($data->status); ?>">
            <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
            <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?></span>
        </div>
        <div class="title-post">
            <?php echo BsHtml::link(Comments::getPostForComment($data->id)->title, $this->createUrl('blog/update', array('id'=>$data->post_id))); ?>
        </div>
        <div class="col-xs-1 image-user">
        <?php
            $images = $data->user->getOneFile('small');

            if(!empty($images))
                echo CHtml::image('/'.$images, $data->user->getFullName());
            else
                echo CHtml::image('/'.Yii::app()->params['noavatar']);
        ?>
        </div>
        <div class="col-xs-10 name">
            <span class="user-name">
                <?php echo $data->user->user_info->nickname; ?>
            </span>
            <span class="date">
                <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $data->time).' в '.date('h:m'); ?>
            </span>
            <?php 
                $complaints = Complaints::getComplaintsForPost($data->id, Comments::MODULE_ID);
                if(count($complaints)>0):
            ?>
            <div class="complaint" style="width: <?php echo count($complaints)*20 ?>px;">
                <?php foreach($complaints as $value): ?>
                <div class="complaint-area">
                    <img src="/images/complaint.png" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?php echo $value['text']; ?>">
                    <img src="/images/delete.png" class="remove-complaint" id="<?php echo $value['id']; ?>" alt="Удалить жалобу">
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <span id="<?php echo $data->id; ?>" class="block-comment"><?php echo ($data->status == $data::STATUS_DONT_PLACEMENT)?'Разблокировать':'Блокировать'; ?></span>

            <span class="blog-rating">
                <?php
                $rating_post = Rating::getRatingForPost($data->id, Comments::MODULE_ID);

                echo ($rating_post>0)?'+'.$rating_post:$rating_post;
                ?>
            </span>

            <div class="text-comment">
                <?php echo $data->text; ?>
            </div>
        </div>
    </div>
</li>