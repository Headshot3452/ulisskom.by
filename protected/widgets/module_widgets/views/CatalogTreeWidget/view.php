<?php
echo '<div id="catalog-menu">';
$this->widget('system.web.widgets.CTreeView', array(
    'data'=>$this->_items,
    'cssFile'=>Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.treeview')).'/jquery.treeview.css',
    'id'=>'catalog-tree-menu'
));
echo '</div>';