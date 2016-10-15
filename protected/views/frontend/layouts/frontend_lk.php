<?php
    $this->renderPartial('//layouts/_header',array());

    $this->renderFile(Yii::getPathOfAlias('application.views').'/_all_alerts.php',array());
?>-
    <div class="container">
        <?php echo $content ;?>
    </div>
</div>

<footer>
</footer>
</body>
</html>
