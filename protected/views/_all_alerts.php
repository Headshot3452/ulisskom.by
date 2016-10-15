<?php
    $this->widget('application.widgets.AlertWidget');

    if (Yii::app()->user->hasFlash('alert-swal'))
    {
        $cs = Yii::app()->getClientScript();
        $message = Yii::app()->user->getFlash('alert-swal');
        $alert_swal = '
            $(window).load(function()
            {
                swal(
                {
                    timer: 500,
                    showConfirmButton: false,
                    width: 126,
                    type: "success",
                    allowOutsideClick: false,
                });
            });
        ';
        $cs->registerPackage('sweet')->registerScript("alert_swal", $alert_swal);
    }

    if (Yii::app()->user->hasFlash('error-swal'))
    {
        $cs=Yii::app()->getClientScript();
        $message=Yii::app()->user->getFlash('error-swal');
        $alert_swal='
            $(window).load(function(){
                    swal("'.$message['header'].'", "'.$message['content'].'", "error");
             });
            ';
        $cs->registerPackage('sweet')->registerScript("alert_swal",$alert_swal);
    }


//    if (Yii::app()->user->hasFlash('storage')) //синхронизации карзины и любимых товаров
//    {
//        $cs=Yii::app()->getClientScript();
//        $get_main_storage='
//              getAjaxStorage("cart",cart);
//              getAjaxStorage("favourites",favourites);
//           ';
//        $cs->registerPackage('cart')->registerScript('get-main-storage',$get_main_storage);
//    }
?>