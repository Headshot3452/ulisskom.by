<?php
    ob_start();

    if ($model->user)
    {
        $image = $model->user->getOneFile('small');
        $image_block = $image ? "<div class='col-xs-3' style='background:url(/$image) center center no-repeat; background-size: contain; width:60px; height:60px;'></div>" : '';
        $id_user = '<div class="number-user"><span class="number">#</span>' . $model->user->id . '<span class="user-status user-status-' . $model->user->status . '">' . (isset($model->user->user_info) ? UserInfo::model()->getStatus($model->user->status) : 'Без статуса') .'</span></div>';
        $user = ($model->user_id) ? $model->user->user_info->getFullName() : ($model->fullname ? : '--');
        $email = isset($model->user->user_info) ? $model->user->email : ($model->email ? : '--');
        $phone = isset($model->user->user_info) ? $model->user->user_info->phone : ($model->phone ? : '--');
    }
    else
    {
        $image_block = '';
        $id_user = '<div class="number-user"><span class="number"># 0</span></div>';
        $user = $model->fullname;
        $email = $model->email;
        $phone = $model->phone;
    }

    echo
    '<div class="container">
        <div class="col-xs-4 review-edit">
            <div class="row">
                Клиент
            </div>
            <div class="row client-info">
                '.$image_block.'
                <div class="col-xs-9 no-padding">
                    '.$id_user.'
                    <div class="user">
                        <img src="/images/icon-admin/little_user_company.png"/>'.$user.'
                    </div>
                    <div class="mail">
                        <img src="/images/icon-admin/little_message_company.png"/>'.$email.'
                    </div>
                    <div class="phone">
                        <img src="/images/icon-admin/little_phone.png"/>'.$phone.'
                    </div>
                </div>
            </div>
            <div class="row">
                Рейтинг
            </div>
            <div class="row rating">';

                for($i = 1; $i < 6; $i++)
                {
                echo '<i class="fa fa-star';
                        if($i > $model->rating)
                        {
                            echo '-o';
                        }
                        echo '"></i>';
                }
                echo
                '<div class="col-xs-12 rating-info">'.$model->rating.' '.$model->getRating($model->rating).'</div>
            </div>
        </div>
        <div class="col-xs-8 review-edit">';

            $form_review = $this->beginWidget('BsActiveForm',
            array(
            'id' => 'catalog-products-review-form',
            'enableAjaxValidation' => false,
            'action' => $this->createUrl('/reviews_save')
            )
            );

            echo $form_review->hiddenField($model, 'id');

            echo
            '<div class="form-group row">
                '.$form_review->labelEx($model, 'header', array('class' => 'control-label')).'
                '.$form_review->textField($model, 'header', array('class' => 'form-control')).'
                '.$form_review->error($model, 'header').'
            </div>

            <div class="form-group row">';
                echo $form_review->labelEx($model, 'text', array('class' => 'control-label'));
                echo $form_review->textArea($model, 'text', array('class' => 'form-control'));
                echo $form_review->error($model, "text");
                echo
                '</div>
            <div class="form-group row">';
                echo $form_review->labelEx($model, 'note', array('class' => 'control-label'));
                echo $form_review->textArea($model, 'note', array('class' => 'form-control'));
                echo $form_review->error($model, "note");
                echo
                '</div>
        </div>

        <div class="form-group buttons">
            '.BsHtml::submitButton(Yii::t("app", "Save"),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)).'
            <span>Отмена</span>
        </div>';

        $this->endWidget();
    echo
    '</div>';

    $content_review = ob_get_contents();

    ob_end_clean();

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_review',
            'htmlOptions' => array(
                'class' => 'modal'
            ),
            'header'  => "Отзыв #".$model->id,
            'content' => $content_review,
            'closeText' => '<img src="/images/icon-admin/modal-close.png">',
        )
    );