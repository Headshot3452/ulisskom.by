<?php
foreach($this->_items as $item)
{
    $image = $item->getOneFile('small');
    if(!$image)
    {
        $image = Yii::app()->params['noimage'];
    }

    echo '<div class="item row">
                    <div class="col-xs-3 text-right">
                        <a href="'.Yii::app()->createUrl('article/item',array('name'=>$item->name)).'"> <img src="'.$image.'" width="50px"></a>
                    </div>

                    <div class="col-xs-9">
                        <div class="title">'.CHtml::link($item->title,array('article/item','name'=>$item->name),array('class'=>'black-link')).'</div>
                        <div class="anons">'.$item->preview.'</div>
                    </div>
           </div>';
}