<div class="form">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'catalog-products-product-form',
            'enableAjaxValidation' => false,
        )
    );

    $action = isset($_GET['tree_id']) ? 'Создание (Новости, акции, статьи)' : 'Редактирование. Новость #'.$model->id;
?>
    <div class="col-xs-12 no-right no-left">
        <h2 class="title_news"><?php echo $action ;?></h2>
<?php
        if (($check = $this->hasButtonsRightMenu('status'))!=null)
        {
            echo '<a data-placement="bottom" data-hint="Сменить статус" href="'.$check['url'].'" class="btn btn-small btn-active hint--bottom hint--rounded"><span class="icon-admin-power-switch-'.($check['active']==true ? 'green' : 'red').'"></span></a>';
        }
        if (($check = $this->hasButtonsRightMenu('delete'))!=null)
        {
            echo '<a data-placement="bottom" data-hint="Удалить новость" href="'.$check['url'].'" class="btn btn-small btn-trash hint--bottom hint--rounded"><span class="fa fa-trash-o"></span></a>';
        }
        echo $this->renderPartial('_form',array('model'=>$model,'form'=>$form),true,false);
?>
    </div>
    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>