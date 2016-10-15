<?php
$this->renderPartial('//profile/_order_table',array('products'=>CJSON::decode($cart['products'])));
?>
<div class="delivery order-info">
    <div class="title">Способ доставки</div>
    <div class="value">
        <?php
        if (isset($delivery['type_delivery']))
        {
           echo Orders::getTypeDelivery($delivery['type_delivery']);
        }
        ?>
    </div>
</div>
<div class="delivery order-info">
    <div class="title">Ф.И.О.</div>
      <div class="value">
        <?php echo $delivery['fio']; ?>
      </div>
</div>
<div class="delivery order-info">
    <div class="title">Телефон</div>
      <div class="value">
        <?php echo $delivery['phone']; ?>
      </div>
</div>
<div class="delivery order-info">
    <div class="title">Адрес</div>
      <div class="value">
        <?php echo $delivery['address']; ?>
      </div>
</div>
<div class="delivery order-info">
    <div class="title">Примичание</div>
      <div class="value">
        <?php echo $delivery['comment']; ?>
      </div>
</div>

