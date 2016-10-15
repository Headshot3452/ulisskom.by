<?php
    $this->renderPartial('_list_products_2',array('model'=>$model, 
    	'count'=>$count, 
    	'dataProducts' => $dataProducts,
    	'status'=>$status,
    	'count_item'=>$count_item,
    	'typeView' => $typeView
    	));
?>