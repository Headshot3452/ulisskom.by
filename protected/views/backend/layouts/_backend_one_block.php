<?php
$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery.ui');
$cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");
?>

<div class="container">
    <?php echo $content ;?>
</div>