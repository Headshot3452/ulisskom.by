<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/jquery.dotdotdot.min.js', CClientScript::POS_END);
$src = '
        $(document).ready(function() {
        $(".one-news.last-news.col-md-3.no-image .title").dotdotdot({
		    ellipsis	: "... ",
		    wrap		: "word",
		    /*	Whether to update the ellipsis: true/"window" */
		    watch		: true,
		    /*	Optionally set a max-height, can be a number or function.
			If null, the height will be measured. */
		    height		: 140,
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
    echo '<div class="one-news no-image last-news col-md-3">
                    <div class="date">'.Yii::app()->dateFormatter->format($this->dateFormat,$item->time).'</div>
                    <h4 class="title">'.CHtml::link($item->title,array('news/item','name'=>$item->name)).'</h4>
           </div>';
}
echo '</div>';