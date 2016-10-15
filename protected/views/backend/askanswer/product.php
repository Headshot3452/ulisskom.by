<div class="form">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'catalog-products-product-form',
            'enableAjaxValidation' => false,
        )
    );
?>
    <div class="col-xs-12 answer-form">
        <div class="title_news">
<?php
            if(!empty($model->id))
            {
                echo '<h2>Вопрос № '.$model->id.'. Редактирование</h2>';
            }
            else
            {
                echo '<h2>Создание вопроса</h2>';
            }

        echo '</div>';

        if (($check=$this->hasButtonsRightMenu('delete'))!=null)
        {
            echo '<a data-placement="bottom" title="Удалить новость" href="'.$check['url'].'" class="btn btn-small btn-trash pull-right"><span class="fa fa-trash-o"></span></a>';
        }
        if (($check=$this->hasButtonsRightMenu('status'))!=null)
        {
            echo '<a data-placement="bottom" title="Сменить статус" href="'.$check['url'].'" class="btn btn-small btn-active pull-right"><span class="icon-admin-power-switch-'.($check['active']==true ? 'green' : 'red').'"></span></a>';
        }

        echo $this->renderPartial('_form',array('model'=>$model,'form'=>$form),true,false);
?>
    </div>
        <div class="form-group buttons">
<?php
            echo BsHtml::submitButton(Yii::t('app','Save'));
?>
            <span>Отмена</span>
        </div>
    <?php $this->endWidget(); ?>

</div>