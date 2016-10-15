<div class="title row">
    <h4>Оставьте свой отзыв</h4>
</div>
<div class="body">
   <span class="text-primary">
     Внимание! Перед публикацией Ваш отзыв будет направлен на модерацию
   </span>
</div>
<div class="footer">
    <?php
    echo BsHtml::link('Оставить отзыв', '#modal_new_review', array('class' => 'btn btn-primary', 'data-toggle' => 'modal'));
    ?>
</div>

<div class="modal fade" id="modal_new_review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <?php
                    if ($setting[2]->status == 1 and Yii::app()->user->isGuest) {
                        echo '<h3  class="modal-title text-center">Ошибка доступа!</h3></div><div class="modal-body text-center">Оставить отзыв могут только<br>зарегистрированные пользователи!</div>';
                    } else {
                    ?>
                    <!--                    <div class="container">-->
                    <h4 class="modal-title">Оставить отзыв</h4>
                </div>
                <?php

                $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                    'id' => 'new-review',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'action' => $this->controller->createUrl('review/add'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => false,
                        'validateOnType' => false,
                        'afterValidate' => 'js:function(form, data, hasError) {
                                            console.log(hasError);
                                            if (!hasError){
                                                jQuery.ajax({
                                                    url: "'.$this->controller->createUrl('review/add').'",
                                                    type: "POST",
                                                    data: $(this).serialize(),
                                                    success: function(data) {
                                                $(".captcha span.fa.fa-refresh").click();
                                                form.trigger("reset");
                                                $("#modal_new_review").modal("hide");
                                                $("#modalOk").modal("show");}
                                                })
                                            }
                                            else
                                                $(".captcha span.fa.fa-refresh").click();
                                            }',
                        'errorCssClass' => 'has-error',
                    ),
                ));
                ?>

                <div class="modal-body">
                    <?php
                    if ($setting[0]->status == 1) {
                        ?>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <?php echo $form->labelEx($review, 'theme'); ?>
                            </div>
                            <div class="col-xs-12">
                                <?php echo $form->dropDownList($review, 'theme', ReviewThemesTree::getAllTreeFilter(), array('empty' => 'Выберите тему отзыва', 'class' => 'form-control', 'placeholder' => '')); ?>
                                <?php echo $form->error($review, 'theme'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>

                    <?php if ($setting[6]->status == 0) {
                        ?>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <?php echo $form->labelEx($review, 'rating'); ?>
                            </div>
                            <div class="col-xs-12">
                                <?php
                                $this->widget('CStarRating', array(
                                    'name' => get_class(ReviewItem::model()) . '[rating]',
                                    'value' => '1',
                                    'minRating' => 1,
                                    'maxRating' => 5,
                                    'titles' => ReviewItem::getRating(),
                                ));
                                ?>

                                <?php echo $form->error($review, 'rating'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php
                    } ?>

                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <?php echo $form->labelEx($review, 'text'); ?>
                        </div>
                        <div class="col-xs-12">
                            <?php echo $form->textArea($review, 'text', array('class' => 'form-control', 'placeholder' => '')); ?>
                            <?php echo $form->error($review, 'text'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <?php if ($setting[2]->status == 0 and Yii::app()->user->isGuest) {
                        if ($setting[3]->status == 1) {
                            ?>

                            <div class="form-group">
                                <div class="col-xs-12 text-left">
                                    <?php echo $form->labelEx($review, 'fullname'); ?><span class="required">*</span>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->textField($review, 'fullname', array('class' => 'form-control', 'placeholder' => '')); ?>
                                    <?php echo $form->error($review, 'fullname'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php
                        }
                        if ($setting[5]->status == 1) {
                            ?>
                            <div class="form-group">
                                <div class="col-xs-12 text-left">
                                    <?php echo $form->labelEx($review, 'phone'); ?><span class="required">*</span>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->textField($review, 'phone', array('class' => 'form-control', 'placeholder' => '+')); ?>
                                    <?php echo $form->error($review, 'phone'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        <?php
                        }
                        if ($setting[4]->status == 1) {
                            ?>
                            <div class="form-group">
                                <div class="col-xs-12 text-left">
                                    <?php echo $form->labelEx($review, 'email'); ?><span class="required">*</span>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->emailField($review, 'email', array('class' => 'form-control', 'placeholder' => '')); ?>
                                    <?php echo $form->error($review, 'email'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php
                        }
                    } ?>

                    <div class="clearfix"></div>

                    <?php
                    if (CCaptcha::checkRequirements()) {
                        ?>
                        <div class="form-group captcha">
                            <div class="col-xs-12">
                                <div class="row col-xs-4 captcha">
                                    <?php $this->widget('CCaptcha', array(
                                        'captchaAction' => 'review/captcha',
                                        'clickableImage' => true,
                                        'buttonLabel' => '<span class="fa fa-refresh"></span>',
                                        'buttonOptions' => array('class' => 'captcha-refresh blue_link')
                                    )); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $form->textField($review, 'verifyCode', array('class' => 'form-control', 'placeholder' => '')); ?>
                                    <?php echo $form->error($review, 'verifyCode'); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <?php
                    echo BsHtml::submitButton(Yii::t('app', 'Send'), array('id' => 'add_btn', 'color' => BsHtml::BUTTON_COLOR_PRIMARY));
                    ?>
                </div>

                <?php $this->endWidget(); ?>

                <!-- form -->
                <?php } ?>
            </div>

        </div>
    </div>
</div>


<!-- Modal OK-->
<div class="modal fade" id="modalOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Отправка завершена</h4>
            </div>
            <div class="modal-body send">
                <p class="text-uppercase"><b>Спасибо!</b></p>

                <p>
                    Ваш отзыв отправлен на модерацию.
                    После модерации отзыв появится на сайте.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Готово</button>
            </div>
        </div>
    </div>
</div>