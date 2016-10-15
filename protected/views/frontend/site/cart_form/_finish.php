<?php
$this->renderPartial('//profile/_order_table',array('products'=>CJSON::decode($cart['products'])));
?>

<div class="payment">
    <div class="title">Способ оплаты</div>
    <div class="value">Наличные</div>
</div>
<div class="delivery">
    <div class="title">Способ доставки</div>
    <div class="value">
    <?php
    if ($delivery['type_delivery'])
    {
        switch($delivery['type_delivery'])
        {
            case '1': echo 'Самовывоз'; break;
            case '2':
                echo 'На адрес';
                $address=Address::getAddressForUser($delivery['address_id'],Yii::app()->user->id);
                $this->renderPartial('//profile/_address_item',array('data'=>$address));
                break;
        }
    }
    ?>
    </div>
</div>
