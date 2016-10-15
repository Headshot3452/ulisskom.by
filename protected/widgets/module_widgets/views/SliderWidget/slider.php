<?php

$cs=Yii::app()->getClientScript();

$carousel='$("#'.$this->id.'").carousel();';
$cs->registerScript('carousel-'.$this->id,$carousel);

echo '<div id="'.$this->id.'" class="carousel slide" data-ride="carousel">';
echo '<!-- Wrapper for slides -->
                    <div class="carousel-inner">';
$active='active';
$count=0;
foreach($this->_items as $item)
{
    $image=$item->getOneFile($this->size);
    if (!empty($image))
    {
        echo '<div class="item '.$active.'" style="height:'.$this->height.'; background:#777777 url(/' . $image . ') center center no-repeat; background-size: contain;">
                            <div class="block-description carousel-caption clear-carousel-caption">
                                <h2 class="title text-center">
                                '.$item->title.'
                                </h2>
                                <div class="description text-center">
                                '.$item->text.'
                                </div>
                            </div>
                    </div>';
        $active='';
        $count++;
    }
}
echo '</div>';

echo '<ol class="carousel-indicators">';
$active='class="active"';
for ($i=0;$i<count($this->_items);$i++)
{
    echo '<li data-target="#'.$this->id.'" data-slide-to="'.$i.'" '.$active.'></li>';
    $active='';
}
echo'</ol>';
echo '<!-- Controls -->
                                  <a class="left carousel-control" href="#'.$this->id.'" role="button" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                  </a>
                                  <a class="right carousel-control" href="#'.$this->id.'" role="button" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                  </a>';
echo '</div>';