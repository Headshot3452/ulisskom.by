<?php
$this->renderPartial('//layouts/_header',array());
$this->renderPartial('//layouts/_top_menu_home',array());
$this->renderFile(Yii::getPathOfAlias('application.views').'/_all_alerts.php',array());
?>

<div class="container-fluid">
    <?php
        echo $content;
    ?>
</div>
<?php
$this->renderPartial('//layouts/_footer',array());
?>