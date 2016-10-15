<?php
$this->renderPartial('//layouts/_header', array());

$this->renderFile(Yii::getPathOfAlias('application.views') . '/_all_alerts.php', array());

if (!empty($this->breadcrumbs)) {
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $this->widget('bootstrap.widgets.BsBreadcrumb', array(
                    'links' => $this->breadcrumbs,
//                    'htmlOptions' =>array('class' => 'breadcrumb col-md-12'),
                ));
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php
echo $content;
?>

<?php
$this->renderPartial('//layouts/_footer', array());
?>