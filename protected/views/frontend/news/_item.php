<?php
    $image = $data->getOneFile('small');
?>
    <div class="item col-md-12">
<?php
        if ($image)
        {
            echo
                '<div class="image-block pull-left col-md-3 no-padding">
                    <a href="'. Yii::app()->createUrl('news/item', array('name' => $data->name)) .'"> <img src="/'. $image .'"></a>
                </div>';
        }
?>
        <div class="description-block <?php echo $image?'col-md-9':''; ?>">
            <div class="date"><?php echo Yii::app()->dateFormatter->format('d MMMM yyyy HH:mm', $data->time);?></div>
            <h3 class="title">
                <?php echo CHtml::link($data->title,array('news/item','name'=>$data->name),array('class'=>'black-link'));?>
            </h3>
            <?php if($data->preview!='') echo "<div class='anons'> $data->preview</div>";?>
        </div>
    </div>