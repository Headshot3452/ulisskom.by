<?php
$products_sortable='
                $("ul.sort_params_phone").nestedSortable({
                    items: "li.sortable_item",
                    listType: "ul",
                    tabSize : 15,
                    maxLevels: 0,
                    protectRoot:true,

                    update:function( event, ui )
                    {
                        var values = parseInt($(ui.item).next().attr("data-sort"));
                        if($(ui.item).is(":last-child"))
                            values = parseInt($(ui.item).prev().attr("data-sort"));
                        if($(ui.item).attr("data-sort")<$(ui.item).next().attr("data-sort"))
                            values = values-1;

                        $.ajax({
                                type:"POST",
                                url:"'.$this->createUrl("params_sort").'",
                                data:{
                                        id:$(ui.item).attr("id"),
                                        index:values,
                                },
                                success: function(data)
                                {
                                    console.log(data);
                                }
                        });
                    }

                });';

$cs=Yii::app()->getClientScript();
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
        'action' => $this->createUrl('update'),
    ));
?>

<div class="row contacts">
	<div class="col-xs-4">
		Обратная связь
	</div>
	<div class="col-xs-8 contacts-setting">
        <label class="checkbox-active <?php echo ($setting->contact_show_feedback==1)?'active':''; ?>"></label>
        <input type="hidden" name="contact_show_feedback" value="<?php echo $setting->contact_show_feedback; ?>">
		<span>Установить модуль “Обратная связь” в контактах</span>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-4">
		Телефоны
	</div>
	<div class="col-xs-8 contacts-phone">
		<span class="add-param add-param-phone">+ Добавить телефон</span>
		<span class="label-block operator-title col-xs-offset-2">Оператор</span>
		<ul class="sort_params_phone">
		<?php 
	    if(isset($data_phone))
	    foreach($data_phone as $key => $value) { ?>
	    <li class="form-group sortable_item row" id="<?php echo $value->id;?>" data-sort="<?php echo $value->sort;?>">
	        <div class="col-xs-4">
	            <?php echo $form->textField($model_phone,'number['.$key.']', array('value'=>$value['number'])); ?>
	        </div>
	        <div class="col-xs-3">
	            <?php echo $form->textField($model_phone,'operator['.$key.']', array('value'=>$value['operator'])); ?>
	        </div>
	        <div class="col-xs-1 col-xs-offset-2">
	        	<img class="delete-phone" id="<?php echo $key; ?>" src="/images/delete.png" alt="Удалить" title="Удалить"/>
	            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
	        </div>
	    </li>
		<?php }?>
		<?php if(count($data_phone)==0): ?>
		<li class="form-group sortable_item row" id="0">
	        <div class="col-xs-4">
	            <?php echo $form->textField($model_phone,'number[0]'); ?>
	        </div>
	        <div class="col-xs-3">
	            <?php echo $form->textField($model_phone,'operator[0]'); ?>
	        </div>
	        <div class="col-xs-1 col-xs-offset-2">
	        	<img class="delete-phone" id="0" src="/images/delete.png" alt="Удалить" title="Удалить"/>
	            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
	        </div>
	    </li>
	    <?php endif; ?>
	    </ul>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-4">
		Адреса
	</div>
	<div class="col-xs-8 contacts-address">
		<span class="add-param add-param-address">+ Добавить адрес</span>
		<div class="sort_params_text">
			<?php 
		    if(isset($data_address))
		    foreach($data_address as $key => $value) { ?>
			<div class="address-block" id="<?php echo $key; ?>">
				<div class="label-block">Контактные данные:</div>
				<img class="delete-address" id="<?php echo $key; ?>" src="/images/delete.png" alt="Удалить" title="Удалить"/>
				<?php
	            $this->widget('application.widgets.ImperaviRedactorWidget',array(
	                'model'=>$model_address,
	                'attribute'=>'text['.$key.']',
	                'plugins' => array(
	                    'imagemanager' => array(
	                        'js' => array('imagemanager.js',),
	                    ),
	                    'filemanager' => array(
	                        'js' => array('filemanager.js',),
	                    ),
	                    'fullscreen'=>array(
	                        'js'=>array('fullscreen.js'),
	                    ),
	                    'table'=>array(
	                        'js'=>array('table.js'),
	                    ),
	                ),
	                'options'=>array(
	                    'lang'=>Yii::app()->language,
	                    'imageUpload'=>$this->createUrl('admin/imageImperaviUpload'),
	                    'imageManagerJson'=>$this->createUrl('admin/imageImperaviJson'),
	                    'fileUpload'=>$this->createUrl('admin/fileImperaviUpload'),
	                    'fileManagerJson'=>$this->createUrl('admin/fileImperaviJson'),
	                    'uploadFileFields'=>array(
	                        'name'=>'#redactor-filename'
	                    ),
	                    'changeCallback'=>'js:function()
	                    {
	                        viewSubmitButton(this.$element[0]);
	                    }',
	                    'buttonSource'=> true,
	                ),
	            ));
	            ?>
	            <div class="label-block">Выберите карту:</div>
				<?php echo $form->dropDownList($model_address, 'map_id['.$key.']', 
							CHtml::listData(Maps::model()->active()->findAll(), 'id', 'title'), 
								array('class'=>'form-control', 'options' => array($value['map_id']=>array('selected'=>true)))); ?>
			</div>
				<?php
				echo	$value='<script type="text/javascript">
						$(".sort_params_text").find("#'.$key.'").find("textarea").html("'.$value->text.'");
						$(".sort_params_text").find("#'.$key.'").find(".redactor-editor").html("'.$value->text.'");
						</script>
					';
				?>
		<?php } ?>
		<?php if(count($data_address)==0): ?>
			<div class="address-block" id="0">
				<div class="label-block">Контактные данные:</div>
				<img class="delete-address" id="0" src="/images/delete.png" alt="Удалить" title="Удалить"/>
				<?php
	            $this->widget('application.widgets.ImperaviRedactorWidget',array(
	                'model'=>$model_address,
	                'attribute'=>'text[0]',
	                'plugins' => array(
	                    'imagemanager' => array(
	                        'js' => array('imagemanager.js',),
	                    ),
	                    'filemanager' => array(
	                        'js' => array('filemanager.js',),
	                    ),
	                    'fullscreen'=>array(
	                        'js'=>array('fullscreen.js'),
	                    ),
	                    'table'=>array(
	                        'js'=>array('table.js'),
	                    ),
	                ),
	                'options'=>array(
	                    'lang'=>Yii::app()->language,
	                    'imageUpload'=>$this->createUrl('admin/imageImperaviUpload'),
	                    'imageManagerJson'=>$this->createUrl('admin/imageImperaviJson'),
	                    'fileUpload'=>$this->createUrl('admin/fileImperaviUpload'),
	                    'fileManagerJson'=>$this->createUrl('admin/fileImperaviJson'),
	                    'uploadFileFields'=>array(
	                        'name'=>'#redactor-filename'
	                    ),
	                    'changeCallback'=>'js:function()
	                    {
	                        viewSubmitButton(this.$element[0]);
	                    }',
	                    'buttonSource'=> true,
	                ),
	            ));
	            ?>
	            <div class="label-block">Выберите карту:</div>
				<?php echo $form->dropDownList($model_address, 'map_id[0]', 
							CHtml::listData(Maps::model()->active()->findAll(), 'id', 'title'), 
								array('class'=>'form-control')); ?>
			</div>
		<?php endif; ?>
			<?php if(isset($_GET['add_address'])): ?>
			<div class="address-block" id="<?php echo $_GET['add_address']+1; ?>">
				<div class="label-block">Контактные данные:</div>
				<?php 
	            $this->widget('application.widgets.ImperaviRedactorWidget',array(
	                'model'=>$model_address,
	                'attribute'=>'text['.++$_GET['add_address'].']',
	                'plugins' => array(
	                    'imagemanager' => array(
	                        'js' => array('imagemanager.js',),
	                    ),
	                    'filemanager' => array(
	                        'js' => array('filemanager.js',),
	                    ),
	                    'fullscreen'=>array(
	                        'js'=>array('fullscreen.js'),
	                    ),
	                    'table'=>array(
	                        'js'=>array('table.js'),
	                    ),
	                ),
	                'options'=>array(
	                    'lang'=>Yii::app()->language,
	                    'imageUpload'=>$this->createUrl('admin/imageImperaviUpload'),
	                    'imageManagerJson'=>$this->createUrl('admin/imageImperaviJson'),
	                    'fileUpload'=>$this->createUrl('admin/fileImperaviUpload'),
	                    'fileManagerJson'=>$this->createUrl('admin/fileImperaviJson'),
	                    'uploadFileFields'=>array(
	                        'name'=>'#redactor-filename'
	                    ),
	                    'changeCallback'=>'js:function()
	                    {
	                        viewSubmitButton(this.$element[0]);
	                    }',
	                    'buttonSource'=> true,
	                ),
	            ));
	            ?>
	            <div class="label-block">Выберите карту:</div>
				<?php echo BsHtml::dropDownList('ContactsAddress[map_id]['.$_GET['add_address'].']', 'ContactsAddress[map_id]['.$_GET['add_address'].']', 
							CHtml::listData(Maps::model()->active()->findAll(), 'id', 'title'), 
								array('class'=>'form-control')); ?>
			</div>
		<?php endif; ?>
	    </div>
	</div>
</div>

<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

<?php $this->endWidget(); ?>

<?php
$cs=Yii::app()->getClientScript();

$checkbox="
        $('label.checkbox-active').click(function(){
        	if($(this).hasClass('active')){
        		$(this).removeClass('active');
        		$(this).next().attr('value',0);
        	}
        	else
        	{
        		$(this).addClass('active');
        		$(this).next().attr('value',1);
        	}
        });
    ";


    $cs->registerPackage('jquery')->registerScript('sub_forms',$checkbox);
    $cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");
?>

<?php
$params='
	function deletePhone(obj)
	{
		var value = obj;
        $(".sort_params_phone").find("#"+value).hide();
        $(".sort_params_phone").find("#"+value).find("input:first").attr("name", "ContactsPhone[remove]["+value+"]");
	}

    $(".add-param-phone").on("click", function(){
        var value;

        $(".sort_params_phone li:last").clone().appendTo(".sort_params_phone");
	
		value = $(".sort_params_phone li").length;

        var obj = $(".sort_params_phone li:last");
        obj.attr("id", value).show();
        obj.find(".col-xs-4").find("input").attr({"name":"ContactsPhone[number]["+value+"]"}).val("");
        obj.find(".col-xs-3").find("input").attr({"name":"ContactsPhone[operator]["+value+"]"}).val("");
    	obj.find("img:first").attr({"id":value});

    	$(".delete-phone").on("click", function(){
        	deletePhone($(this).attr("id"));
    	});
    });

    $(".delete-phone").on("click", function(){
        deletePhone($(this).attr("id"));
    });

	$(".add-param-address").on("click", function(){
        var maxValue=0;
        var value;

        $("div.address-block").each(function(){
            var element =  $(this), 
                value = element.attr("id");
              if(value > maxValue) {
                maxValue = value;
        }});

        window.location.href = "?add_address="+maxValue;
    });

    $(".delete-address").on("click", function(){
        var value = $(this).attr("id");
        $(".sort_params_text").find("#"+value).hide();
        $(".sort_params_text").find("#"+value).find("textarea").attr("name", "ContactsAddress[remove]["+value+"]");
    });
';

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('params',$params);

?>