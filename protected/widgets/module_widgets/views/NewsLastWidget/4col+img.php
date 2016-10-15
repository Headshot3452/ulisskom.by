<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/jquery.dotdotdot.min.js', CClientScript::POS_END);
$src = '
        $(document).ready(function() {
        $(".one-news.last-news.col-md-3 .title").dotdotdot({
		    ellipsis	: "... ",
		    wrap		: "word",
		    /*	Whether to update the ellipsis: true/"window" */
		    watch		: true,
		    /*	Optionally set a max-height, can be a number or function.
			If null, the height will be measured. */
		    height		: 65,
	    });
	    });
        ';
$cs->registerScript('dots'.$this->id, $src);

echo '<div class="last-news">';
foreach($this->_items as $item)
{
    $image = $item->getOneFile('small');
    if(!file_exists($image))
        $image = Yii::app()->params['noimage'];
    echo '<div class="one-news last-news col-md-3">
                    <div class="image col4 text-center">
                    ' . CHtml::link('', array('news/item', 'name' => $item->name),array('style'=>'background:rgba(119,119,119,0.3) url(/'.$image.') center center no-repeat; background-size: contain;')) . '
                    </div>
                    <div class="date">'.Yii::app()->dateFormatter->format($this->dateFormat,$item->time).'</div>
                    <h4 class="title">'.CHtml::link($item->title,array('news/item','name'=>$item->name)).'</h4>
           </div>';
}
echo '</div>';