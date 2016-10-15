<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <?php
        $cs = Yii::app()->getClientScript();
        $css_path=Yii::getPathOfAlias('webroot.css');

        $cs->registerCoreScript('jquery', CClientScript::POS_END);

        $cs->registerPackage('bootstrap');

        $cs->registerCssFile(
            Yii::app()->assetManager->publish($css_path.'/style.css')
        );

        ?>
        <title><?php echo $this->seo['title']; ?></title>
        <meta name="keywords" content="<?php echo $this->seo['keywords']; ?>" />
        <meta name="description" content="<?php echo $this->seo['description']; ?>" />
    </head>
    <body>
        <div class="wrapper">

<?php

$this->renderFile(Yii::getPathOfAlias('application.views').'/_all_alerts.php',array());

?>
    <div class="container">

        <div class="col-xs-4"></div>

        <div class="col-xs-4">
            <h3 class="h2 text-center">
                <?php echo $this->getPageTitle(); ?>
            </h3>

            <?php
                echo $content;
            ?>
        </div>

        <div class="col-xs-4"></div>
    </div>

</div>
    <footer>
    </footer>
</body>
</html>
