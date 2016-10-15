<div class="row profileblog">
    <h2 class="col-md-12">Настройка уведомлений</h2>

    <div class="clearfix"></div>

    <div class="col-md-6 notifications">
        <form>
        <div class="">
            <input value="1" id="notif_0" type="checkbox" name="notif[]">
            <label for="notif_0">Принимать уведомления об отправке заказа</label>
        </div>
            <div class="row col-md-12 submit-buttons">
                <?php
                echo BsHtml::submitButton(Yii::t('app','Save'),
                    array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'class' => ''));
                echo CHtml::link(Yii::t('app','Cancel'), array('profileorder/index'), array('class' => 'cancel_link'));
                ?>
            </div>
            </form>
    </div>
</div>