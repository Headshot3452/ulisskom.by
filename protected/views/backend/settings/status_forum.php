<div class="forum-status col-xs-8 col-xs-offset-4">
<?php
$form=$this->beginWidget('BsActiveForm', array(
    'id'=>'forum-status-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of BsActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
    'action' => $this->createUrl('update_forum_status'),
));
?>
    <div class="form-group row forum-status-title">
        <div class="col-xs-5">
            Значение группы:
        </div>
        <div class="col-xs-5">
            Период:
        </div>
    </div>

    <ul class="sort_params">
<?php
if(isset($data))
    foreach($data as $key => $value) { ?>
        <li class="form-group row" id="<?php echo $value->id;?>">
            <div class="col-xs-5">
                <?php echo $form->textField($model,'text['.$value->id.']', array('value' => $value['text'])); ?>
            </div>
            <div class="col-xs-5 period">
                <div class="dropdown status-forum">
                    <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
                        <?php echo ForumStatus::getPeriod($value->period); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a id="1">1 мес.</a></li>
                        <li><a id="2">3 мес.</a></li>
                        <li><a id="3">6 мес.</a></li>
                        <li><a id="4">9 мес.</a></li>
                        <li><a id="5">1 год</a></li>
                        <li><a id="6">2 года</a></li>
                        <li><a id="7">3 года</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-1">
                <img class="delete" id="<?php echo $value->id ?>" src="/images/delete.png" alt="Удалить" title="Удалить"/>
            </div>
            <input type="hidden" name="<?php echo 'ForumStatus[period]['.$value->id.']'; ?>" value="<?php echo $value->period; ?>">
        </li>
    <?php } ?>
    <?php if(count($data)==null): ?>
        <li class="form-group row" id="1">
            <div class="col-xs-5">
                <?php echo $form->textField($model,'text[1]'); ?>
            </div>
            <div class="col-xs-5 period">
                <div class="dropdown status-forum">
                    <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
                        <?php echo ForumStatus::getPeriod(1); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a id="1">1 мес.</a></li>
                        <li><a id="2">3 мес.</a></li>
                        <li><a id="3">6 мес.</a></li>
                        <li><a id="4">9 мес.</a></li>
                        <li><a id="5">1 год</a></li>
                        <li><a id="6">2 года</a></li>
                        <li><a id="7">3 года</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-1">
                <img class="delete" id="1" src="/images/delete.png" alt="Удалить" title="Удалить"/>
            </div>
            <input type="hidden" name="<?php echo 'ForumStatus[period][1]'; ?>" value="1">
        </li>
    <?php endif; ?>
    </ul>

    <div class="form-group">
        <div class="col-xs-12">
            <span class="add_param">+ Добавить поле</span>
        </div>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

 <?php $this->endWidget(); ?>
</div>

<?php
$params='
    function deletePhone(obj)
    {
        var value = obj;
        $(".sort_params").find("li#"+value).hide();
        $(".sort_params").find("li#"+value).find("input:first").attr("name", "ForumStatus[remove]["+value+"]");
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

        $(".sort_params > li:last").clone().appendTo(".sort_params");

        var obj = $(".sort_params > li:last");
        obj.attr("id", maxValue).show();
        obj.find(".col-xs-5:first").find("input").attr({"name":"ForumStatus[text]["+maxValue+"]"}).val("");
        obj.find("img:last").attr({"id":maxValue});
        obj.find("input[type=hidden]").attr({"name":"ForumStatus[period]["+maxValue+"]", "value":"1"});

        $(".delete").on("click", function(){
            deletePhone($(this).attr("id"));
        });
        $(".status-forum ul li a").on("click", function(){
            var value = $(this).attr("id");

            $(this).parents("li.form-group").find("input[type=hidden]").val(value);
            $(this).parents("li.form-group").find(".status-forum button").html($(this).text()+"<span class=\"caret\"></span>");
        });
    });

    $(".delete").on("click", function(){
        deletePhone($(this).attr("id"));
    });

    $(".status-forum ul li a").on("click", function(){
        var value = $(this).attr("id");

        $(this).parents("li.form-group").find("input[type=hidden]").val(value);
        $(this).parents("li.form-group").find(".status-forum button").html($(this).text()+"<span class=\"caret\"></span>");
    });
';

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('params',$params);

?>