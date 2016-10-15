<div class="col-md-4">
    <div class="row one-readership">
        <?php
            $images = $data->follower->getOneFile('original');

            if(!empty($images))
            {
                echo CHtml::link(CHtml::image('/'.$images, $data->follower->login, array('class'=>isset($data->follower->usersSession->id)?'online':'offline')),
                    $this->createUrl('blog/user', array('id'=>$data->follower->id)),
                    array('class'=>'avatar'));
            }
            else
                echo CHtml::link(CHtml::image('/'.Yii::app()->params['noavatar'], $data->follower->login, array('class'=>isset($data->follower->usersSession->id)?'online':'offline')),
                    $this->createUrl('blog/user', array('id'=>$data->follower->id)),
                    array('class'=>'avatar'));
        ?>
        <div class="col-md-9 info">
            <div class="">
                <a href="<?php echo $this->createUrl('blog/user', array('id'=>$data->follower->id)); ?>">
                    <?php echo $data->follower->user_info->nickname; ?>
                </a>
            </div>
            <div class="time">
                <?php echo Users::getUserTimeOnSite($data->follower->id); ?> на сайте
            </div>

            <?php $address = Address::model()->findByAttributes(array('user_id'=>$data->follower->id)); ?>
            <div class="city">
                <?php echo ($address)?$address->country.' , '.$address->city:''; ?>
            </div>
        </div>
    </div>
</div>