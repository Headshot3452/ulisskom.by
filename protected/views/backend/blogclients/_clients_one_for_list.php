<li class="one_item feedback blog" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-1 text-center">
            <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
            <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
        </div>
        <div class="col-xs-1 image-user">
            <?php
            $images = $data->getOneFile('original');

            if(!empty($images))
                echo CHtml::link(CHtml::image('/'.$images, $data->getFullName()), $this->createUrl('blogclients/blog', array('id'=>$data->id)));
            else
                echo CHtml::link(CHtml::image('/'.Yii::app()->params['noavatar']), $this->createUrl('blogclients/blog', array('id'=>$data->id)));
            ?>
        </div>
        <div class="col-xs-3 name">
            <div>#&nbsp;&nbsp;&nbsp;<?php echo $data->id; ?><span style="color: <?php echo ($data->status==1)?"#009f00":"#ff0000"; ?>"> <?php echo UserInfo::getStatus($data->status); ?></span></div>
            <div class="user-name"><img src="/images/feedback_user.png"><?php echo $data->getFullName(); ?></div>
            <div><img src="/images/feedback_email.png"><?php echo $data->email; ?></div>
            <div><img src="/images/feedback_phone.png"><?php echo $data->user_info->phone; ?></div>
        </div>
        <div class="col-xs-2 rating">
            <div class="result"><?php echo Yii::app()->format->formatNumber(Rating::getRatingForUser($data->id, true)); ?> <span>( +1 )</span></div>
            <div class="result"><?php echo Yii::app()->format->formatNumber(Rating::getRatingForUser($data->id, false)*-1); ?> <span>(&nbsp;&nbsp;-1 )</span></div>
            <span>Регистрация: <div><?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $data->create_time); ?> г.</div></span>
        </div>
        <div class="col-xs-2 posts">
            <div class="result"><?php echo $count_post = Blog::model()->count('user_id=:user_id', array(':user_id'=>$data->id)); ?></div>

            <?php if($count_post!=0): ?>
                <span>Последний: <div><?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', Blog::BlogLastForUser($data->id)->time); ?> г.</div></span>
            <?php endif; ?>
        </div>
        <div class="col-xs-2 comments">
            <div class="result"><?php echo $count_comment = Comments::model()->count('user_id=:user_id', array(':user_id'=>$data->id)); ?></div>

            <?php if($count_comment!=0): ?>
                <span>Последний: <div><?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', Comments::CommentLastForUser($data->id)->time); ?> г.</div></span>
            <?php endif; ?>
        </div>
        <div class="col-xs-1 status">
            <?php echo isset($data->usersSession->id) ? '<div class="v-seti">В сети</div>' : '<div class="offline">Последний сеанс <span>'.Yii::app()->dateFormatter->format('dd MMMM yyyy', $data->update_time).'</span></div>'; ?>
            <span><?php echo ForumStatus::getStatusForum($data->id); ?></span>
        </div>
    </div>
</li>