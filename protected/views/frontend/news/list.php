<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/jquery.dotdotdot.min.js', CClientScript::POS_END);
$src = '
$(document).ready(function() {
        $(".item .description-block.col-md-9").dotdotdot({
		ellipsis	: "... ",
		wrap		: "word",
		/*	Whether to update the ellipsis: true/"window" */
		watch		: true,
		/*	Optionally set a max-height, can be a number or function.
			If null, the height will be measured. */
		height		: 150,
	});
	});
';
$cs->registerScript('dots', $src);
?>
<div class="container">
    <h1><?php echo Yii::t('app', 'The news page') ?></h1>

    <div class="news row">
        <div class="col-md-8">
            <?php
            $this->widget('bootstrap.widgets.BsListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'ajaxUpdate' => false,
                'itemsCssClass' => 'row',
                'template' => '{items}<div class="col-xs-12 row pull-left">{pager}</div>',
            ));
            ?>
        </div>

        <div class="col-md-4 side-bar">
            <div class="col-md-12 widget">
                <div class="title row">
                    <div class="caption cat-categories">Виджет</div>
                </div>
                <div class="body">
                    <p>
                        Что-нибудь
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>