<?php
$image = $data->getOneFile('small');
if(!$image)
    $image = Yii::app()->params['noimage'];
?>
<div class="small" id="products-list">
<div class="one_item" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-1 image">
            <img width="50" height="50" src="/<?php echo $image;?>" alt="" title="" />
        </div>
        <div class="col-xs-2 buttons">
            <a href="<?php echo $this->createUrl('active',array('id'=>$data->id))?>"  data-placement="bottom" title="<?php echo ($data->status==CatalogProducts::STATUS_OK ? 'Есть доступ' : 'Нет доступа'); ?>" class="btn btn-small btn-active"><span class="icon-admin-power-switch-<?php echo ($data->status==CatalogProducts::STATUS_OK ? 'green' : 'red'); ?>"></span></a>
            <a href="<?php echo $this->createUrl('delete_product', array('id' => $data->id )) ?>"  data-placement="bottom" title="Удалить" class="btn btn-small btn-trash"><span class="fa fa-trash-o"></span></a>
        </div>
    </div>
</div>
</div>
<?php
$header_popovers = ' $(".buttons .btn").tooltip();';
$cs = Yii::app()->getClientScript();
$cs->registerScript("header_popovers", $header_popovers);