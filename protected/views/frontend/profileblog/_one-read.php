<div class="col-md-4">
    <div class="row one-readership">
        <?php
            $images = $data->user->getOneFile('original');

            if(!empty($images))
            {
                echo CHtml::link(CHtml::image('/'.$images, $data->user->login, array('class'=>isset($data->user->usersSession->id)?'online':'offline')),
                    $this->createUrl('blog/user', array('id'=>$data->user->id)),
                    array('class'=>'avatar'));
            }
            else
                echo CHtml::link(CHtml::image('/'.Yii::app()->params['noavatar'], $data->user->login, array('class'=>isset($data->user->usersSession->id)?'online':'offline')),
                    $this->createUrl('blog/user', array('id'=>$data->user->id)),
                    array('class'=>'avatar'));
        ?>
        <div class="col-md-11 info">
            <div class="">
                <a href="<?php echo $this->createUrl('blog/user', array('id'=>$data->user->id)); ?>">
                    <?php echo $data->user->user_info->nickname; ?>
                    <span class="badge pull-right">
                        <?php echo '+'.$data->view; ?>
                    </span>
                </a>
            </div>
            <div class="time">
                <?php echo Users::getUserTimeOnSite($data->user->id); ?> на сайте
            </div>

            <?php $address = Address::model()->findByAttributes(array('user_id'=>$data->user->id)); ?>
            <div class="city">
                <?php echo ($address)?$address->country.' , '.$address->city:''; ?>
            </div>
        </div>
    </div>
</div>