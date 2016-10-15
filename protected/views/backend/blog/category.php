<div class="col-xs-12">
    <div class="title_news">
        <?php if(!empty($model->id)){ ?>
    <h2>Тема  # <?php echo $model->id;?>. Редактирование</h2>
<?php }else{ ?>
    <h2>Создание новой темы</h2>
<?php }
        ?>
    </div>
<?php $this->renderPartial('_form_category',array('model'=>$model)); ?>
</div>
