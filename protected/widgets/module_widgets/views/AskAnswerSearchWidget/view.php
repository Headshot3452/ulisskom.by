<?php echo CHtml::beginForm(array('askanswer/index'), 'GET', array('id' => 'searchsubmit')); ?>

<div class="title row">
    <h4>Поиск вопроса</h4>
</div>
<div class="row body">
    <div class="col-md-12">
        <div class="form-group">
            <?php
                echo CHtml::label('Искать вопрос', 'text');
                echo CHtml::textField('name', '', array('placeholder' => 'Текст вопроса'));
            ?>
        </div>
        <div class="form-group">
            <?php
                echo CHtml::label('Шаг 1. Выберите категорию', 'root');
                echo CHtml::dropdownList('ask_category', '', CHtml::listData(AskAnswerTree::model()->findAll('level=2 ORDER BY lft ASC'), 'id', 'title'), array('id' => 'ask-category', 'placeholder' => 'Выбор категории', 'empty'=>'Выберите категорию'));
            ?>
        </div>
        <div class="form-group">
            <?php
                echo CHtml::label('Шаг 2. Выберите группу вопросов', 'group');
                echo CHtml::dropdownList('ask_group', '', array(), array('id' => 'ask-group', 'empty'=>'Выполните шаг 1', 'placeholder' => 'Выполните шаг 1', 'disabled' => 'disabled'));
            ?>
        </div>
    </div>
</div>
<div class="row footer">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary pull-left">Искать</button>
        <button id="reset-ask-search" class="btn btn-default pull-right">Сбросить</button>
    </div>
</div>

<?php echo CHtml::endForm(); ?>

<?php
$cs = Yii::app()->getClientScript();
$search = '$("#ask-category").change(function() {
            $("#ask-group").removeAttr("disabled").attr("placeholder","Выберите группу");
            $("#ask-group option[value=\"\"]").text("Выберите группу");
         });
         $("#reset-ask-search").click(function(){
            $("#text").val(null);
            $("#ask-category").val(null);
            $("#ask-group option[value=\"\"]").text("Выполните шаг 1");
            $("#ask-group").val(null);
            $("#ask-group").attr("disabled","disabled");

         });

         $("select#ask-category").on("change", function(){
            var value = $(this).val();

            $.ajax({
                type: "POST",
                data: {id:value},
                url: "'.$this->controller->createUrl('askanswer/index').'",
                success: function(data){
                    $("select#ask-group").html(data);
                }
            });
         });
         ';
$cs->registerScript("search-ask-" . $this->id, $search);