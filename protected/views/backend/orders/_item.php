<tr class="one-order <?php echo (in_array($data->status, array(-1, -2, -3, 0, 5))) ? 'complete' : '';?>">
    <td class="text-center cursor-pointer" onclick="location.href='<?php echo $this->createUrl('orders/order', array('id' => $data->id)) ;?>'">
        <?php echo $data->id ?>
    </td>
    <td class="text-center cursor-pointer" onclick="location.href='<?php echo $this->createUrl('orders/order',array('id' => $data->id));?>'">
<?php
        echo Yii::app()->dateFormatter->format('dd.MM.yyyy <br> HH:mm', $data->create_time);
?>
        <br><br>
<?php
        if ($data->comment != '')
        {
            echo '<span class="cursor-pointer fa fa-exclamation-triangle color-yellow"title="' . $data->comment . '" data-toggle="tooltip" data-placement="top"></span>';
        }
?>
    </td>
    <td class="cursor-pointer" onclick="location.href='<?php echo $this->createUrl('orders/order',array('id'=>$data->id));?>'">
        <div class="id-status"><span class="color-gray"># <?php echo isset($data->user->id) ? $data->user->id : 0 ;?></span>
<?php
            if(isset($data->user))
            {
//                $color = $data->user->status == 1 ? " color-green" : " color-red";
//                echo '<span class="user-status'.$color.'">';
//                echo UserInfo::model()->getStatus($data->user->status);

                $fio = $data->user->getFullName();
                $email = $data->user->email;
                $phone = isset($data->user->user_info) ? $data->user->user_info->phone : '';
            }
            else
            {
                $user_info = unserialize($data['user_info']);
                $fio = $user_info['last_name'] .' '. $user_info['name'] . ' ' . $user_info['patronymic'];
                $email = $user_info['email'];
                $phone = $user_info['phone'];
            }
?>
        </div>
        <div class="name">
            <span class="icon-admin-user"></span> <?php echo $fio ;?>
        </div>
        <div class="email color-gray">
            <i class="fa fa-envelope-o"></i> <?php echo $email ;?>
        </div>
        <div class="phone color-gray">
            <span class="icon-admin-phone"></span>
            <?php echo $phone ;?>
        </div>
    </td>
    <td class="cursor-pointer"  onclick="location.href='<?php echo $this->createUrl('orders/order',array('id'=>$data->id));?>'">
        <div class="text-right"><?php echo $data->count; ?> <span class="color-gray">шт.</span></div>
        <div class="text-right">
            <span class="color-primary"><?php echo $data->f_sum; ?></span>
            <span class="color-gray text-uppercase"><?php echo $this->currency_ico_view ;?></span></div>
        <br>

        <div class="status text-right">

<!--                <span class="cursor-pointer smile fa-stack color-green" title="Позитивный" data-toggle="tooltip"-->
<!--                      data-placement="top">-->
<!--                    <span class="fa fa-circle fa-stack-2x"></span>-->
<!--                    <span class="fa fa-smile-o fa-lg fa-stack-1x fa-inverse"></span>-->
<!--                </span>-->
<!--                <span class="cursor-pointer smile fa-stack color-red" title="Негативный" data-toggle="tooltip" data-placement="top">-->
<!--                    <span class="fa fa-circle fa-stack-2x"></span>-->
<!--                    <span class="fa fa-frown-o fa-lg fa-stack-1x fa-inverse"></span>-->
<!--                </span>-->
<!--                <span class="cursor-pointer smile fa-stack color-gray" title="Нейтральный" data-toggle="tooltip" data-placement="top">-->
<!--                    <span class="fa fa-circle fa-stack-2x"></span>-->
<!--                    <span class="fa fa-meh-o fa-lg fa-stack-1x fa-inverse"></span>-->
<!--                </span>-->
<?php
            $paid_color = 'gray';

            switch($data->paid)
            {
                case 0:
                    $paid_color = 'gray';
                    break;
                case 1:
                    $paid_color = 'green';
                    break;
                case 2:
                    $paid_color = 'red';
                    break;
                case 3:
                    $paid_color = 'orange';
                    break;
            }
?>

            <span class="cursor-pointer fa-stack color-<?php echo $paid_color; ?>"
                  title="<?php echo Orders::getPaid($data->paid); ?>" data-toggle="tooltip" data-placement="top">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-usd fa-stack-1x fa-inverse"></span>
            </span>
        </div>
    </td>
    <td class="cursor-pointer" onclick="location.href='<?php echo $this->createUrl('orders/order',array('id' => $data->id));?>'">
        <div>
            <?php echo isset($data->manager) ? $data->manager->user_info->getFullName() : '-'; ?>
        </div>
        <div>
            <?php echo isset($data->picker) ? $data->picker->name : '-' ?>
        </div>
        <div>
            <?php echo isset($data->executor) ? $data->executor->name : '-' ?>
        </div>
        <div class="labels">
<?php
            for($i = 1; $i < 5; $i++)
            {
                $note = "note".$i;
                $_note = $data->$note ? unserialize($data->$note) : "";

                if($_note)
                {
                    echo
                        '<span class="cursor-pointer fa fa-star fa-lg color-'.$_note["label"].'"
                            title="'.$_note["text"].'" data-toggle="tooltip"
                            data-placement="top"></span>';
                }
            }
?>
        </div>
    </td>
    <td class="col-md-2 col-info">
        <div class="status text-right" data-order="<?php echo $data->id ;?>">
<?php
            if (in_array($data->status, array(1, 2, 3, 4)))
            {
                for ($i = 1; $i <= 4; $i++)
                {
                    echo '<div data-toggle="tooltip" data-status="'.$i.'" data-placement="bottom" title="' . Orders::getStatus($i) . '" class="order-status' . $i . ' ' . (($data->status < $i) ? 'inactive' : '') . ' cursor-pointer"></div>';
                }
                echo '<div data-toggle="tooltip" data-status="'.$i.'" data-placement="bottom" title="' . Orders::getStatus(5) . '" class="order-status5 inactive cursor-pointer"></div>';
            }
            elseif (in_array($data->status, array(-1, -2, -3, 5, 0)))
            {
                echo '<div data-toggle="tooltip" data-status="'.$data->status.'" data-placement="bottom" title="' . Orders::getStatus($data->status) . '" class="order-status' . $data->status . ' cursor-pointer"></div>';
            }
?>
        </div>
        <div class="time">
            <div class="pull-left">
<?php
                $flag = 0;
                $pickup = 0;

                if ($data->status != Orders::STATUS_COMPLETED && $data->status > 0)
                {
                    $flag = 1;
                    echo '<span class="color-gray">Осталось: </span> ';
                }
                else
                {
                    $date = explode(' ', $data->f_update_time);
                    echo '<span class="color-gray">Завершен: </span> ';
                }

                if ($data->type_delivery == Orders::ORDER_DELIVERY_TO_ADDRESS)
                {
                    echo '<div class="icon-admin-delivery cursor-pointer" data-toggle="tooltip" data-placement="bottom" title="' . Orders::getTypeDelivery($data->type_delivery) . '"></div>';
                }
                elseif ($data->type_delivery == Orders::ORDER_DELIVERY_TO_POST)
                {
                    echo '<div class="icon-admin-delivery_post cursor-pointer" data-toggle="tooltip" data-placement="bottom" title="' . Orders::getTypeDelivery($data->type_delivery) . '"></div>';
                }
                else
                {
                    $pickup = 1;
                    echo '<div class="icon-admin-self-pickup cursor-pointer" data-toggle="tooltip" data-placement="bottom" title="' . Orders::getTypeDelivery($data->type_delivery) . '"></div>';
                }
?>
            </div>
        </div>
        <div class="times pull-left">
            <div>
<?php
                if ($flag)
                {
                    if(!$pickup)
                    {
                        echo $data->f_delivery_end;
                    }
                }
                else
                {
                    $date = explode(' ', $data->f_update_time);
                    if (isset($date[1]))
                    {
                        echo '<span data-toggle="tooltip" data-placement="bottom" title="' . $date[1] . '" >' . $date[0] . '</span>';
                    }
                }
        echo
            '</div>';

            if(!$pickup)
            {
                echo
                    '<div>'.$data->f_delivery_time.'</div>
                    <div>'.$data->delivery_hours.'</div>';
            }
?>
        </div>
    </td>
</tr>