<?php
$cs=Yii::app()->getClientScript();
$cs->registerPackage('slider-slick');
$slider='
                $("#'.$this->id.'").slick({

                  slidesToShow: '.$this->view_product.',
                  slidesToScroll: 1,
                  autoplay: true,
                  autoplaySpeed: 2000,
                });
        ';

echo '<div id="'.$this->id.'" class="slider-products">';
foreach($this->_data as $item)
{
    $url=$this->controller->createUrl('catalog/tree',array('url'=>$item->getUrlForItem($this->root_id)));
    $image=$item->getOneFile('big');
    if (!$image)
    {
        $image=Yii::app()->params['noimage'];
    }
    echo '<div class="product">';
    echo '<div class="title text-center"><a href="'.$url.'">'.CHtml::encode($item->title).'</a></div>';
    echo '<div class="image image-shadow"><a href="'.$url.'"><img src="/'.$image.'" class="img-responsive"></a></div>';
    echo '<div class="price-block text-center"><div class="price"><span>'.Yii::app()->format->formatNumber($item->price).'</span> руб.</div></div>';
    echo '<div class="text-center">
                       <a href="javascript:void(0);" class="addProduct btn" data-id="'.$item->id.'" data-title="'.CHtml::encode($item->title).'" data-price='.$item->price.'" data-url="'.$url.'" data-image="'.$image.'" data-discount="0">
                          В корзину
                      </a>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';

$cs->registerScript($this->id.'slick',$slider);