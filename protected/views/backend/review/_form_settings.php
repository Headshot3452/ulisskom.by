<?php
    $check = '
        if ($("#checkbox_1").prop("checked"))
        {
            $("#main-left-tree-menu a").removeAttr("style");
            $("#main-left-tree-menu a .icon").removeAttr("style");
        }
        else
        {
            $("#main-left-tree-menu a").css("color","#979797");
            $("#main-left-tree-menu a .icon").css("color","#979797");
        }

        if ($("#checkbox_3").prop("checked"))
        {
            $("#checkbox_4, #checkbox_5, #checkbox_6").attr("onclick", "return false").parent().parent().addClass("disabled");
        }
        else
        {
            $("#checkbox_4, #checkbox_5, #checkbox_6").removeAttr("onclick").parent().parent().removeClass("disabled");
        }

        $("#checkbox_1").change(function ()
        {
            if ($(this).prop("checked"))
            {
                $("#main-left-tree-menu a").removeAttr("style");
                $("#main-left-tree-menu a .icon").removeAttr("style");
            }
            else
            {
                $("#main-left-tree-menu a").css("color","#979797");
                $("#main-left-tree-menu a .icon").css("color","#979797");
            }
        });

        $("#checkbox_3").change(function ()
        {
            if ($(this).prop("checked"))
            {
                $("#checkbox_4, #checkbox_5, #checkbox_6").attr("onclick", "return false").parent().parent().addClass("disabled");
            }
            else
            {
                $("#checkbox_4, #checkbox_5, #checkbox_6").removeAttr("onclick").parent().parent().removeClass("disabled");
            }
        });
    ';

    $cs = Yii::app()->getClientScript();
    $cs->registerScript("check", $check);
?>

<h2>Настройки параметров отзывов</h2>
<div class="form">
    <ul class="">
<?php foreach($data as $key => $value) { ?>
    <li class="form-group sortable_item row" id="<?php echo $value->id;?>">
        <div class="col-xs-12">
            <?php echo BsHtml::checkBox('checkbox['.$value->id.']',$value->status==1?true:false,array('class'=>'checkbox group')); ?>
            <?php echo BsHtml::label('','checkbox_'.$value->id,false,array('class'=>'checkbox')); ?>
            <label for='checkbox_<?php echo $value->id; ?>' class='check-label'><?php echo $value->name; ?></label>
        </div>
    </li>
<?php } ?>
    </ul>
	<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>
</div><!-- form -->
