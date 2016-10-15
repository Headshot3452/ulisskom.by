<?php
    $this->renderPartial('//layouts/_header',array());
    $this->renderPartial('//layouts/_top_menu_select',array());
    $this->renderFile(Yii::getPathOfAlias('application.views').'/_all_alerts.php',array());
?>
    <div class="container">
<?php
        switch ($this->layout_in)
        {
            case 'backend_left_tree_with_buttons': $template='//layouts/_backend_two_blocks_with_buttons'; break;
            case 'backend_left_menu':case 'backend_left_tree': $template='//layouts/_backend_two_blocks'; break;
            case 'backend_one_block': $template='//layouts/_backend_one_block'; break;
        }

        if (isset($template))
        {
            $this->renderPartial($template,array('content'=>$content));
        }
?>
    </div>
<?php
    $this->renderPartial('//layouts/_footer',array());
?>
