<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form BsActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=>'menu-_menu-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of BsActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="item-menu item">
        <div class="items">
            <?php
            $items=$model->menuItems;

            $result=Core::getTreeForField($items);

            foreach($result as $item)
            {
                echo viewTree($item,$form);
            }

            function viewTree($cat,$form)
            {
                $items='';
                if (!empty($cat['children']))
                {
                    foreach($cat['children'] as $item)
                    {
                        $items.=viewTree($item,$form);
                    }
                }
                return $cat['item']->getFormChild('',$form,Yii::app()->controller->getCurrentLanguage()->id,$items);
            }
            ?>
        </div>
        <a href="javascript:void(0)" class="add-children" parent="0"><?php echo Yii::t('app','Add'); ?></a>
    </div>


	<div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="template" style="display: none">
    <div class="child">
        <?php
            $item=new MenuItem();
            echo $item->getFormChild('777',$form,$this->getCurrentLanguage()->id);
        ?>
    </div>
</div>

<?php
$cs=Yii::app()->getClientScript();

$items="
    function prepareAttrs(item,idNumber)
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
{
}
";

$cs->registerPackage('jquery')->registerScript('items',$items);
$cs->registerCss('menu-style',$css);
?>