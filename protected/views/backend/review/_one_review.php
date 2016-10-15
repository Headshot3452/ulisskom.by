<?php
if (!empty($data)) {
    $link = $this->createUrl('',array('id' => $data->id));
    $status='';
    switch ($data->status) {
        case 1:
            $status = 'new';
            break;
        case 2:
            $status = 'moderate';
            break;
        case 5:
        case 6:
            $status = 'placement';
            break;
        case 7:
            $status = 'rejected';
            break;
    }
    ?>

    <li class="col-xs-12 one_item no-padding status status-<?php echo $status; ?>">
        <div class="col-xs-1 text-center" id="<?php echo $data->id; ?>">
            <!--                <div class="">-->
            <div><?php echo $data->id; ?></div>
            <?php echo BsHtml::checkBox('checkbox[' . $data->id . ']', false, array('class' => 'checkbox group')); ?>
            <?php echo BsHtml::label('', 'checkbox_' . $data->id, false, array('class' => 'checkbox')); ?>
            <div><?php echo date("d.m.Y H:m", $data->create_time); ?></div>
            <!--                </div>-->
        </div>
        <div onclick="location.href='<?php echo $link; ?>'" class="col-xs-3 user-info no-padding">
            <div class="user">
                <img src="/images/icon-admin/little_user_company.png"/>
                <?php echo $data->user ? $data->user->getFullName() : $data->fullname?:'--'; ?>
            </div>
            <div class="phone">
                <img src="/images/icon-admin/little_phone.png"/>
                <?php echo ($data->user and $data->user->user_info) ? $data->user->user_info->phone:$data->phone?:'--'; ?>
            </div>
            <div class="mail">
                <img src="/images/icon-admin/little_message_company.png"/>
                <?php echo $data->user ? $data->user->email : $data->email?:'--'; ?>
            </div>
            <div class="rating">
                <?php
                for($i=1;$i<6;$i++){
                    echo '<i class="fa fa-star';
                    if($i>$data->rating)
                        echo '-o';
                    echo '"></i>';
                }
                ?>
            </div>
        </div>
        <div onclick="location.href='<?php echo $link; ?>'" class="col-xs-2 theme">
            <?php echo $data->theme ? $data->theme->title:''; ?>
        </div>
        <div onclick="location.href='<?php echo $link; ?>'" class="col-xs-6 text">
            <?php echo $data->text; ?>
        </div>
    </li>
<?php
}
?>