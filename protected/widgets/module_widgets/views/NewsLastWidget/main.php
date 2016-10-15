<?php
foreach($this->_items as $item)
{
    $image = $item->getOneFile('small');
    $url = $this->controller->getUrlById(Yii::app()->params['pages']['novosti']).'/'.$item->name;

    echo
    '<div class="col-xs-4">
        <div class="row">
            <div class="col-xs-3">
                '.CHtml::link('<img style="width:100%" src="'.$image.'">',
                    $url, array(), array('style' => 'width:100%; display:"inline-block;"')).'
            </div>
            <div class="col-xs-9">
                <p class="news-date">'.date($this->dateFormat, $item->time).'</p>
                <h5 class="news-title"><a href="/'.$url.'">'.$item->title.'</a></h5>
                <p class="news-preview">'.$item->preview.'</p>
            </div>
        </div>
    </div>';
}