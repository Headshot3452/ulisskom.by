<?php
    $image = $data->getOneFile('small');
    if(!$image || !is_file($image))
    {
        $image = Yii::app()->params['noimage'];
    }
    $link = $this->createUrl('update').'?id='.$data->id;
?>

<li class="one_item" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-2">
            <div class="status <?php echo ($data->status == 1) ? 'active' : 'not_active'; ?>">
                <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
                <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
                <div class="identity"><?php echo $data->id ;?></div>
                <div class="date text-center">
                    <?php echo date("d.m.Y H:m", $data->time); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-1">
            <a href="<?php echo $link ;?>">
                <img style="margin-top: 12px;" width="50" height="50" src="/<?php echo $image;?>" alt="" title="" />
            </a>
        </div>
        <div class="col-xs-8 name">
            <?php echo BsHtml::link($data->title, $link); ?>
            <?php if(!empty($data->article)) {?>
            <div class="article">
                <span>Арт.</span><?php echo $data->article; ?>
            </div>
            <?php }?>
        </div>
        <div class="col-xs-1 text-center"><img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/></div>
    </div>
</li>