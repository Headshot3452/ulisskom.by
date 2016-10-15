<li class="one_item feedback" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-1 text-center" style="border-color:<?php echo $data::getColorStatus($data->status); ?>" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $data::getStatus($data->status); ?>">
            <span class="number-answer"><?php echo $data->id; ?></span>
            <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
            <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
            <span class="date"><?php echo date("d.m.Y H:m", $data->time); ?></span>
        </div>
        <div class="col-xs-3 name">
            <?php
            foreach(SettingsFeedback::model()->findAll('system=1') as $key => $value) { ?>
                <div class="feedback_system">
                    <?php
                        if($key==0)
                            echo '<img src="/images/icon-admin/little_user_company.png">';
                        if($key==1)
                            echo '<img src="/images/icon-admin/little_phone.png">';
                        if($key==2)
                            echo '<img src="/images/icon-admin/little_message_company.png">';
                    ?>
                    <?php
                        $feedback = FeedbackAnswers::getAnswersForFeedback($value->id, $data->id);
                        echo isset($feedback->value)?$feedback->value:'';
                    ?>
                </div>
            <?php } ?>

            <?php
            foreach(FeedbackAnswers::getFeedbackAnswers($data->parent_id) as $key => $value){?>
                <div class="feedback_system">
                    <?php echo $value->name; ?>:
                    <?php
                        $feedback = FeedbackAnswers::getAnswersForFeedback($value->id, $data->id);
                        echo isset($feedback->value)?$feedback->value:'';
                    ?>
                </div>
            <?php }?>
        </div>
        <div class="col-xs-2 tema">
            <?php echo $data->tree->title; ?>
        </div>
        <div class="col-xs-5 name">
            <?php echo $data->ask; ?>
        </div>
    </div>
</li>