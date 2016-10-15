<?php

if ($data->user) {
    $image = $data->user->getOneFile('small');
    $image_block = $image ? "<div class='col-xs-3 image' style='background:url(/$image) center center no-repeat; background-size: contain; width:64px; height:64px;'></div>" : '';
//    $id_user ='<div class="user">'.$data->user->getFullname?:'N/A'.'</div>';
}
?>
<li class="one_item">
    <div class="row client-info">
        <div class="col-xs-9">
            <?php echo $data->user ? $image_block : ''; ?>
            <div class="user">
                <b><?php echo isset($data->user->user_info) ? $data->user->user_info->getFullName() : ($data->fullname ?: 'N/A'); ?></b>
            </div>
            <div class="time">
                <?php echo date('d F Y H:i', $data->create_time); ?>
            </div>
        </div>
        <div class="col-xs-3 text-right">
            <div class="rating">
                <?php
                for ($i = 1; $i < 6; $i++) {
                    echo '<i class="fa fa-star';
                    if ($i > $data->rating)
                        echo '-o';
                    echo '"></i>';
                }
                ?>
            </div>
            <div class="rating-info"><?php echo $data->rating . ' ' . $data->getRating($data->rating); ?></div>
        </div>

    </div>
    <div class="row review">
            <?php echo $data->theme ? '<h3 class="theme col-md-12">'.$data->theme->title.'</h3>' :''; ?>
        <div class="col-xs-12 text">
            <?php echo $data->text; ?>
        </div>
    </div>
</li>
