<?php

$cs = Yii::app()->getClientScript();
$cs->registerPackage('lightbox');

$image = $data->getOneFile('small');
$path_big = $data->getOneFile("big");
if(!$image){
    $image = Yii::app()->params['noimage'];
    $path_big =Yii::app()->params['noimage'];
}
else{
}
?>
<li class="one_item gallery_images" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-2 status_id">
            <div class="status <?php echo ($data->status == 1) ? 'active' : 'not_active'; ?>">
                <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
                <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
                <?php echo BsHtml::label($data->id,'ch',false,array()); ?>
            </div>
        </div>
        <a href="/<?php echo $path_big;?>" data-lightbox="roadtrip"><div class="col-xs-2 image" style="background:url('/<?php echo $image;?>') center center no-repeat; background-size: contain; ">
        </div></a>
        <div class="col-xs-8 name" onclick="location.href='<?php echo $this->createUrl('update_product').'?id='.$data->id; ?>'">
            <?php $data->title; ?>
        </div>
    </div>
</li>