<!DOCTYPE html>
<html lang="<?php echo Yii::app()->getLanguage(); ?>">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?php echo isset($this->pageTitle) ? $this->pageTitle : 'IdeaCms - CMS' ;?></title>
<?php
    $cs = Yii::app()->getClientScript();

    $cs->registerCoreScript('jquery', CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->getBaseUrl().'/js/core.js',CClientScript::POS_END);

    $cs->registerPackage('bootstrap');
    $cs->registerCssFile(Yii::app()->getBaseUrl().'/css/non-responsive.css');

    $cs->registerCssFile(Yii::app()->getBaseUrl().'/css/bd.css');
    $cs->registerCssFile(Yii::app()->getBaseUrl().'/css/bd_m.css');
    $cs->registerCssFile(Yii::app()->getBaseUrl().'/css/bd_g.css');
    $cs->registerCssFile(Yii::app()->getBaseUrl().'/css/font-awesome.css');
?>
</head>
<body>

    <div class="wrapper">
        <div class="head-line">
            <div class="container">
                <?php echo BsHtml::link(BsHtml::image('/images/sign-out-option.png', 'Перейти на сайт'), '/', array('class' => 'pull-left hint--bottom hint--rounded', 'data-hint' => 'Перейти на сайт', 'style' => 'margin-left: 20px; margin-top: 2px;') ) ;?>
                <?php echo BsHtml::link(BsHtml::image('/images/logout.png', 'Выход'), $this->createUrl('/logout'), array('class' => 'pull-right hint--bottom hint--rounded', 'data-hint' => 'Выход', 'data-placement' => 'bottom', 'style' => 'margin-right: 20px; margin-top: 2px;') )?>
            </div>
        </div>
<?php
        $cs = Yii::app()->getClientScript();
        $cs->registerPackage('hint');
?>