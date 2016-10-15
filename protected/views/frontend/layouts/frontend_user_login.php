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
<div class="wrapper user_login">

<?php
    $this->renderFile(Yii::getPathOfAlias('application.views').'/_all_alerts.php',array());
?>
    <div class="container">
        <div class="col-md-4 col-sm-3 col-xs-1"></div>

        <div class="col-xs-4">
            <a href="/" class="back_to_site"><i class="fa fa-long-arrow-left"></i>Вернуться на сайт</a>
            <div class="logo text-center"><?php echo BsHtml::image('/images/user_logo.png');?></div>
<?php
            echo $content;
?>
            <span class="iwl"><i class="fa fa-copyright"></i>Собственность IWL</span>
        </div>

        <div class="col-xs-4"></div>
    </div>

</div>
<footer>
</footer>
</body>
</html>
