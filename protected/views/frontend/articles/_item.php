<?php

$image = $data->getOneFile('small');
if(!$image)
{
    $image = Yii::app()->params['noimage'];
}

echo '<div class="item row">
                    <div class="image-block text-right">
                        <a href="'.Yii::app()->createUrl('articles/item',array('name'=>$data->name)).'"> <img src="/'.$image.'" class="thumbnail" width="260px"></a>
                    </div>

                    <div class="description-block">
                        <div class="title">'.CHtml::link($data->title,array('articles/item','name'=>$data->name),array('class'=>'black-link')).'</div>
                        <div class="anons">'.$data->preview.'</div>
                    </div>
           </div>';

?>