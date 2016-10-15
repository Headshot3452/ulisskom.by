<div class="row">
    <h2 class="col-md-12"><?php echo Yii::t('app','Delivery addresses')?></h2>

    <div class="address-list col-md-8">
        <?php
        $cs = Yii::app()->getClientScript();
        $header_popovers = ' $(".buttons .btn").tooltip();';
        $cs->registerScript("header_popovers", $header_popovers);
        $cs->registerScript('addressdelete',
            '
                $(document).ready(function(){

                    $(".address-edit-block .delete").click(function(){
                        if(confirm("Вы уверены, что хотите удалить адрес?"))
                        {
                            var id = $(this).data("id");
                            $.ajax({
                               type: "POST",
                               url: "' . $this->createUrl('deleteAddress') . '?id="+id,
                               success: function(msg){
                                 window.location.reload();
                               }
                            });
                        }
                        return false;
                    });

                    $("input#Address_default").change(function(){
                         var id = $(this).data("id");
                            $.ajax({
                               type: "POST",
                               url: "' . $this->createUrl('setDefaultAddress') . '?id="+id,
                            });
                    });
                });
            '
        );

        $i = 1;
        foreach ($address as $item) {
            echo '<div class="address-block">
                        <div class="row address-edit-block">
                            <h3 class="col-xs-3">
                                Адрес ' . $i . '
                            </h3>

                            <div class="col-xs-6 check-default">
                                ' . CHtml::activeRadioButton($item, 'default', array('data-id' => $item->id)), ' Адрес по умолчанию
                            </div>

                            <div class="col-xs-3 text-right buttons">
                                ' . CHtml::link('<span class="fa fa-pencil"></span>', $this->createUrl('address', array('id' => $item->id)), array('class' => 'edit btn btn-default', 'data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"Редактировать адрес")) . '
                                ' . CHtml::link('<span class="fa fa-trash"></span>', '#', array('class' => 'delete btn btn-default', 'data-id' => $item->id, 'data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"Удалить адрес")) . '
                            </div>
                        </div>';
            $this->renderPartial('_address_item', array('data' => $item));
            $i++;
            echo '</div>';
        }
        ?>

        <?php echo CHtml::link('<span class="fa fa-plus-circle"></span> Добавить адрес доставки', $this->createUrl('address'), array('class' => 'edit')); ?>
    </div>
</div>