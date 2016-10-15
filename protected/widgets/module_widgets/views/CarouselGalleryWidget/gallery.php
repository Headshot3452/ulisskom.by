<?php
$cs=Yii::app()->getClientScript();

$cs->registerPackage('jquery')->registerCssFile(
    Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css').'/owl.carousel.css')
);
$cs->registerPackage('jquery')->registerScriptFile(
    Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js').'/owl.carousel.min.js')
);

$carousel='$("#'.$this->id.'").owlCarousel({
                // Configuration goes here
                 items : 2,
                 autoPlay : true,
                 stopOnHover : true,
            });';

$cs->registerScript("carousel-".$this->id,$carousel);

echo '<div id="'.$this->id.'" class="owlCarousel">';

foreach($this->_items as $key=>$item)
{
    if(($key+1) % 2)
    {$color = 'red';}
    else
    {$color = 'blue';}

    $image=$item->getOneFile($this->size);
    echo '<div class="gallery-carousel-block '.$color.'">
             <div class="description-block pull-left">
                <div class="title">
                    '.$item->title.'
                </div>
                <div class="description">
                    '.$item->description.'
                </div>
            </div>

            <div class="arrow-block pull-left">
            </div>

            <div class="arrow pull-left">
            </div>

            <div class="image pull-left">
                <img src="/'.$image.'">
            </div>
        </div>';
}

echo '
            </div>';