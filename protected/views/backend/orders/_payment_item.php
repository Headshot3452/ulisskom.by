<tr class="one-order">

    <td class="text-center cursor-pointer">
        <div>
            <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy <br> HH:mm', $data->create_time) ;?>
        </div>
        <br/>
        <div>
            <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy <br> HH:mm', $data->update_time) ;?>
        </div>
    </td>

    <td class="text-left cursor-pointer">
        <div>
            <span><?php echo $data->pay_system ;?></span>
            <div><?php echo $data->recipient ;?></div>
        </div>
        <br/>
        <div class="pay">
            <div>Оплата: # <?php echo $data->pay_num . "; " . $data->text ;?></div>
        </div>
    </td>

    <td class="cursor-pointer">
        <div class="text-left">
            <?php echo CHtml::link($data->order_id, $this->createUrl('orders/order', array('id' => $data->order_id))) ;?>
            </a>
        </div>
        <div class="text-left">
            <?php echo $data->account ;?>
        </div>
    </td>

<?php
    switch($data->status)
    {
        case 1:
            $color = 'green';
            break;
        case 2:
            $color = 'orange';
            break;
        case 3:
            $color = 'red';
            break;
        case 4:
            $color = 'gray';
            break;
    }

//    echo $filled_int = sprintf("%06d", 12)
?>

    <td class="cursor-pointer">
        <div class="text-left">
           <span class="status <?php echo $color ;?>"><?php echo $data->getStatus($data->status) ;?></span>
            <div class="user-info">
                <div class="number-user">
                    # <span class="id"><?php echo isset($data->user) ? $data->user->id : '' ;?></span>
<!--                    <span class="good">Хороший клиент</span>-->
                </div>
                <div class="name">
                    <span class="icon-admin-user"></span>
                    <?php echo isset($data->user) ? $data->user->getFullName() : '' ;?>
                </div>
                <div class="email">
                    <i class="fa fa-envelope-o"></i>
                    <?php echo isset($data->user) ? $data->user->email : '' ;?>
                </div>
            </div>
        </div>
    </td>

    <td class="cursor-pointer">
        <div class="text-right">
            <?php echo '<span class="status '.$color.'">'.number_format($data->summa, 2, ".", " ") . '</span>' . " " . $data->currency_id ;?>
        </div>
    </td>
</tr>