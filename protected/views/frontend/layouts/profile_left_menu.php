<?php
$this->renderPartial('//layouts/_header', array());

$this->renderFile(Yii::getPathOfAlias('application.views') . '/_all_alerts.php', array());

$cs = Yii::app()->getClientScript();
$src = ' $(".submit-buttons").hide();

    $("body").on("change click", "input, textarea, select, " +
                "button, img.fa-close, label.checkbox-active", function()
    {
        viewSubmitButton(this);
    });

    function viewSubmitButton(obj)
{
    var el = $(obj).closest("form").find(".submit-buttons");

    if (!el.is(":visible"))
    {
        el.show(500);
    }
}
    ';

$cs->registerScript('submitButtons', $src);

if (!empty($this->breadcrumbs)) {
    echo '<div>';

    $this->widget('bootstrap.widgets.BsBreadcrumb', array(
        'links' => $this->breadcrumbs,
    ));

    echo '</div>';
}
?>
<div class="container">
    <div id="profile">
        <div class="row col-md-12">
            <h1><?php echo Yii::t('app','Personal Area');?></h1>

            <h2 class="fullname"><?php echo UserInfo::getForUser(Yii::app()->user->getUser()->id)->getFullName(); ?></h2>
        </div>
        <div class="row tabs-menu">
            <div class="col-md-12">
                <?php

                $ar=explode('/', Yii::app()->request->pathInfo);

                echo BsHtml::tabs(
                    array(
                        array(
                            'label' => Yii::t('app', 'Orders'),
                            'url' => array('profileorder/index'),
                            'active' => $ar[0]=='profileorder'?true:false,
                        ),
                        array(
                            'label' => Yii::t('app', 'Blog'),
                            'url' => array('profileblog/index'),
                            'active' => $ar[0]=='profileblog'?true:false,
                        ),
                        array(
                            'label' => Yii::t('app', 'Profile'),
                            'url' => array('profile/index'),
                            'active' => $ar[0]=='profile'?true:false,
                        ),
                    ),
                    array(
                        'class' => 'text-uppercase',
                    )
                );
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">

                <div class="col-md-12 widget">
                    <div class="title row border-bottom">
                        <div class="caption cat-categories"><?php echo Yii::t('app', isset($this->menu_title)?$this->menu_title:'Menu')?></div>
                    </div>
                    <div class="row categories-widget">
                        <?php

                        $menu = $this->getLeftMenu();

                        if (isset($menu[0])) {
                            $this->widget('bootstrap.widgets.BsNav',
                                array(
                                    'items' => $menu,
                                    'encodeLabel'=> false,
//                                'htmlOptions' => array('class' => '')
                                )
                            );
                        }
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-md-9">
                <?php echo $content; ?>
            </div>

        </div>
    </div>
</div>
</div>

<footer>
</footer>
</body>
</html>
