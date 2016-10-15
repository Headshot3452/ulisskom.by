<div class="articles-list">
<?php
    $this->widget('bootstrap.widgets.BsListView',array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_item',
            'ajaxUpdate'=>false,
            'template'=>'{items}<div class=\"row\"><div class=\"col-xs-6\">{pager}</div></div>',
    ));
?>

</div>