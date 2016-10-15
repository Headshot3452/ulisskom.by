<div class="main-title">Мои заказы</div>

<div class="row period">
    <div class="col-xs-3">
        <?php echo CHtml::dropDownList('period','',$this->order_periods,array('class'=>'form-control',
            'ajax'=>array(
                'type'=>'GET',
                'url'=>CController::createUrl('profile/index'),
                'update'=>'#orders',
                'data'=>array(
                    'period'=>'js:this.value',
                ),

            ),
        )) ?>
    </div>
    <div class="col-xs-9 ">
        <div class="field-note">Показать заказы за истекший период времени</div>
    </div>
</div>

<div id="orders">
    <?php $this->renderPartial('_orders_list',array('orders'=>$orders)); ?>
</div>