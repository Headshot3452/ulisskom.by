<div class="row">
    <div class="col-xs-12">
    <?php
        echo $form->render();

        $cs=Yii::app()->getClientScript();

        $cart_back='$("body").on("click","input[name=back]",
            function()
            {
                  $(this).closest("form").yiiactiveform();
                  $(this).closest("form").submit();
            }
        )';
        $cs->registerScript('cart_back',$cart_back);
    ?>
    </div>
</div>
