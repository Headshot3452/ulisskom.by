<?php
$products_sortable='
                $("ul.sort_params_groups").nestedSortable({
                    items: "li.sortable_item",
                    listType: "ul",
                    tabSize : 15,
                    maxLevels: 0,

                    update:function( event, ui )
                    {
                        $.ajax({
                                type:"POST",
                                url:"'.$this->createUrl("params_sort").'",
                                data:{
                                        id:$(ui.item).attr("id"),
                                        index:$(ui.item).index()+1,
                                },
                                success: function(data)
                                {
                                    console.log(data);
                                }
                        });
                    }

                });';

$cs=Yii::app()->getClientScript();
$cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");
$cs->registerScript("products_sortable",$products_sortable);

?>

<?php
    $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'catalog-products-product-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
        'action' => $this->createUrl('settings_group', array('id'=>$_GET['id'])),
    ));
?>

<div class="groups">
		<span class="add-param add-param-groups">+ Добавить группу</span>
		<div class="label-block">Группы адресов:</div>
		<ul class="sort_params_groups">
			<?php 
		    if(isset($data))
		    foreach($data as $key => $value) { ?>
		    <li class="form-group sortable_item row" id="<?php echo $value['id'];?>">
		        <div class="col-xs-6">
		            <?php echo $form->textField($model,'title['.$value['id'].']', array('value'=>$value['title'])); ?>
		        </div>
		        <div class="col-xs-1 col-xs-offset-2">
		        	<img class="delete-groups" id="<?php echo $value['id']; ?>" src="/images/delete.png" alt="Удалить" title="Удалить"/>
		            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
		        </div>
		    </li>
			<?php } ?>
			<?php if(count($data)==null): ?>
				<li class="form-group sortable_item row" style="display: none;">
		        <div class="col-xs-6">
		            <?php echo BsHtml::textField('title','title'); ?>
		        </div>
		        <div class="col-xs-1 col-xs-offset-2">
		        	<img class="delete-groups" src="/images/delete.png" alt="Удалить" title="Удалить"/>
		            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
		        </div>
		    </li>
			<?php endif; ?>
	    </ul>
</div>

<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

<?php $this->endWidget(); ?>

<?php
$params='
	function deletePhone(obj)
	{
		var value = obj;
        $(".sort_params_groups").find("#"+value).hide();
        $(".sort_params_groups").find("#"+value).find("input:first").attr("name", "MapsPlacemarkGroup[remove]["+value+"]");
	}

    $(".add-param-groups").on("click", function(){
    	var maxValue=0;
        var value;

        $(".sort_params_groups li").each(function(){
            var element =  $(this), 
                value = element.attr("id");
              if(value > maxValue) {
                maxValue = value;
        }});

        maxValue++;

        $(".sort_params_groups li:last").clone().appendTo(".sort_params_groups");

        var obj = $(".sort_params_groups li:last");
        obj.attr("id", maxValue).show();
        obj.find(".col-xs-6").find("input").attr({"name":"MapsPlacemarkGroup[title]["+maxValue+"]"}).val("");
    	obj.find("img:first").attr({"id":maxValue});

    	$(".delete-groups").on("click", function(){
        	deletePhone($(this).attr("id"));
    	});
    });

    $(".delete-groups").on("click", function(){
        deletePhone($(this).attr("id"));
    });
';

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('params',$params);

?>