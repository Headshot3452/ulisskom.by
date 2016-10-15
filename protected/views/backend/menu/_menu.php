<?php
    /* @var $this MenuController */
    /* @var $model Menu */
    /* @var $form BsActiveForm */
?>

<div class="form form-structure">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
        'id' => 'menu-_menu-form',
        'enableAjaxValidation' => false,
        )
    );
?>
    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model,'title'); ?>:</div>
            <?php echo $form->textField($model,'title'); ?>
            <?php echo $form->error($model,'title'); ?>
    </div>

    <?php
    $data = array();

    foreach(Structure::getCategory($this->getCurrentLanguage()->id) as $category)
    {
        if ($category['id'] != $model->id)
        {
            $data[$category['id']] = str_repeat('*',$category['level'] - 1).' '.$category['title'];
        }
    }
    ?>

    <div class="form-group">
        <div class="label-block">Связь со структурой сайта:</div>
            <?php echo $form->dropDownList($model, 'structure_id', $data, array('class'=>'form-control')); ?>
    </div>

    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model,'url'); ?>:</div>
            <?php echo $form->textField($model,'url', array('placeholder'=>'URL')); ?>
            <?php echo $form->error($model,'url'); ?>
    </div>

    <?php
        $data = array();
        $data[0] = 'Выберите';

        foreach($this->getCategories() as $category)
        {
            if ($category['id'] != $model->id)
            {
                $data[$category['id']] = str_repeat('*',$category['level'] - 1).' '.$category['title'];
            }
        }
    ?>
        <?php if(!$model->isRoot()): ?>
            <div class="form-group">
                <div class="label-block">Родительский пункт меню:</div>
                    <?php 
                        if($model->level != 2)
                            echo $form->dropDownList($model,'parent_id',$data,array('class'=>'form-control', 'options' => array(isset($_GET['parent'])?$_GET['parent']:'0'=>array('selected'=>true))));
                        else
                        {
                            $parent=$model->parent()->find();
                            echo $form->dropDownList($model,'parent_id',$data,array('class'=>'form-control', 'value'=>0, 'empty'=>$parent->title));
                        }
                    ?>
            </div>
        <?php endif; ?>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
    $cs = Yii::app()->getClientScript();

    $items = "
        function prepareAttrs(item, idNumber)
        {
            item.attr('name', item.attr('name').replace(/\[\d+\]/, '['+idNumber+']'));
            item.attr('id', item.attr('id').replace(/_\d+_/, '_'+idNumber+'_'));
        }

        function initNewInputs(divs, idNumber )
        {
             divs.find('input').each(function(index){
                prepareAttrs($(this),idNumber);
             })

             divs.find('select').each(function(index){
                prepareAttrs($(this),idNumber);

                $(this).find('option:selected').removeAttr('selected');
             })
        }

        $('body').on('click','.add-children',function()
        {
            div=$('.template .child').clone();
            key='p'+$('.item-menu .item').length;
            initNewInputs(div,key);
            div.find('input[id$=parent_id]').val($(this).attr('parent'));
            div.find('.add-children').attr('parent',key);
            $(this).closest('.item').find(' > .items').append(div.html());
        });

        $('body').on('click','.del-form',function(){
                $(this).closest('.item').parent().remove();
        });
    ";

    $css=".items
    {
        clear:both;
        margin:10px 0 10px 20px;
    }
    .item
    {}
    ";

    $cs->registerPackage('jquery')->registerScript('items', $items);
    $cs->registerCss('menu-style', $css);