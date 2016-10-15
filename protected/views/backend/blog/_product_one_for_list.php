<li class="one_item feedback blog" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-1 text-center" style="border-color:<?php echo $data::getColorStatus($data->status); ?>">
            <span class="number-answer"><?php echo $data->id; ?></span>
            <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
            <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
            <span class="date"><?php echo date("d.m.Y H:m", $data->time); ?></span>
        </div>
        <div class="col-xs-2 name">
            <div>
                <img src="/images/feedback_user.png">
                <?php echo $data->user->getFullName(); ?>
            </div>
            <div>
                <img src="/images/feedback_user.png">
                <?php echo $data->user->user_info->nickname; ?>
            </div>
            <div>
                <img src="/images/feedback_email.png">
                <?php echo $data->user->email; ?>
            </div>
            <div class="complaint">
                <?php foreach(Complaints::getComplaintsForPost($data->id, $this->module_id) as $value): ?>
                <div class="complaint-area">
                    <img src="/images/complaint.png" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?php echo $value['text']; ?>">
                    <img src="/images/delete.png" class="remove-complaint" id="<?php echo $value['id']; ?>" alt="Удалить жалобу">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-xs-3 tema">
            <?php echo BsHtml::link(BlogTree::CreatePathForItem($data->id),$this->createUrl('update').'?id='.$data->id); ?>
            <div class="tags-blog">
                <?php 
                    foreach(TagItems::getTagsForItem($data->id, $this->module_id) as $value)
                    {
                        echo '<span>'.$value->tag['title'].'<i id="'.$value['id'].'" class="fa fa-times"></i>,</span>';
                    }
                ?>
            </div>
        </div>
        <div class="col-xs-5 name">
            <?php echo $data->title; ?>
        </div>
    </div>
</li>