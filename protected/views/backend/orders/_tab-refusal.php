<?php
/* @var $order Orders */
?>
<div class="row payment-info">
    <div class="col-md-12">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="p" class="col-md-3 control-label text-right">Причина отказа:</label>
                <div class="col-md-5">
                    <select class="form-control" id="p">
                        <option>Причина</option>
                        <option>Причина</option>
                        <option>Причина</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="comment" class="col-md-3 control-label text-right">Комментарий:</label>
                <div class="col-md-5">
                    <textarea class="form-control" id="comment" placeholder="Введите текст комментария к отказу"></textarea>
                </div>
            </div>

            <div class="form-group buttons">
                <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
                <span>Отмена</span>
            </div>
        </form>
    </div>

</div>
