<div class="col-xs-6 tag-item">
    <div class="border-tag">
        <span class="tag-name"><?php echo $data->title; ?></span>
        <?php echo BsHtml::textField('title', $data->title); ?>
        <img src="/images/delete.png" class="remove-tag" id="<?php echo $data->id; ?>" alt="Удалить тэг">
        <button type="button" id="<?php echo $data->id; ?>" class="btn btn-default btn-change"><span class="glyphicon glyphicon-pencil"></button>
    </div>
</div>