<?php
$products_sortable='
                $(".form .sort_params").nestedSortable({
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
$cs->registerScript("products_sortable",$products_sortable);

?>


<div class="form feedback-setting">
    <div class="form-group">
        <div class="col-xs-12 title">
            <?php echo Yii::t('app', 'Add and edit');?>
        </div>
        <div class="col-xs-5">
            <?php echo $form->labelEx($model,'name'); ?>
        </div>
        <div class="col-xs-5 col-xs-offset-1">
            <?php echo $form->labelEx($model,'type'); ?>
        </div>
    </div>

    <ul class="sort_params">
<?php 
    if(isset($data))
    foreach($data as $key => $value) { ?>
    <li class="form-group sortable_item" id="<?php echo $value->id;?>">
        <div class="col-xs-5">
            <?php echo $form->textField($model,'name['.$value->id.']', array("disabled"=> (!empty($value['system'])) ? "disabled" : "", 'value' => $value['name'])); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="col-xs-5 col-xs-offset-1">
            <?php echo $form->dropDownList($model,'type['.$value->id.']',SettingsFeedback::getAllType(), array("disabled"=> (!empty($value['system'])) ? "disabled" : "", 'options' => array($value['type']=>array('selected'=>true)))  ); ?>
            <?php echo $form->error($model,'type'); ?>
        </div>
        <div class="col-xs-1">
            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
            <?php if(empty($value->system)) { ?>
                <img class="delete" id="<?php echo $value->id ?>" src="/images/delete.png" alt="Удалить" title="Удалить"/>
            <?php } ?>
        </div>
    </li>
<?php } ?>
<?php if(count($data)==null): ?>
    <li class="form-group sortable_item" id="0">
        <div class="col-xs-5">
            <?php echo $form->textField($model,'name[0]'); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="col-xs-5 col-xs-offset-1">
            <?php echo $form->dropDownList($model,'type[0]',SettingsFeedback::getAllType()); ?>
            <?php echo $form->error($model,'type'); ?>
        </div>
        <div class="col-xs-1">
            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
            <?php if(empty($value->system)) { ?>
                <img class="delete" id="0" src="/images/delete.png" alt="Удалить" title="Удалить"/>
            <?php } ?>
        </div>
    </li>
<?php endif; ?>
    </ul>

    <?php echo $form->hiddenField($model, 'tree_id', array('value'=>(isset($_GET['category_id']))?$_GET['category_id']:'')); ?>

    <div class="form-group">
        <div class="col-xs-12">
            <input hidden name="count_params_feedback" value="<?php echo count($data)?>"/>
            <span class="add_param">+ Добавить поле</span>
        </div>
    </div>

</div><!-- form -->

<?php
$params='
    function deletePhone(obj)
    {
        var value = obj;
        $(".sort_params").find("#"+value).hide();
        $(".sort_params").find("#"+value).find("input:first").attr("name", "SettingsFeedback[remove]["+value+"]");
    }

    $(".add_param").on("click", function(){
        var maxValue=0;
        var value;

        $(".sort_params li").each(function(){
            var element =  $(this), 
                value = element.attr("id");
              if(value > maxValue) {
                maxValue = value;
        }});
    
        maxValue++;

        $(".sort_params li:last").clone().appendTo(".sort_params");

        var obj = $(".sort_params li:last");
        obj.attr("id", maxValue).show();
        obj.find(".col-xs-5:first").find("input").attr({"name":"SettingsFeedback[name]["+maxValue+"]"}).val("");
        obj.find(".col-xs-offset-1").find("select").attr({"name":"SettingsFeedback[type]["+maxValue+"]", "value":""});
        obj.find("img:last").attr({"id":maxValue});

        $(".delete").on("click", function(){
            deletePhone($(this).attr("id"));
        });

    });

    $(".delete").on("click", function(){
        deletePhone($(this).attr("id"));
    });
';

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('params',$params);

?>