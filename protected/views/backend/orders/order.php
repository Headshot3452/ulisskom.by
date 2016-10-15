<?php
    $avatar = @unserialize($order->user->avatar);
    if ($avatar && is_array($avatar))
    {
        $avatar = $order->user->getOneFile('small');
        $src = $avatar;
    }
    else
    {
        $src = '/' . Yii::app()->params['noavatar'];
    }
?>

<div class="row one-order-info">
    <div class="col-md-4 user-info no-padding">
        <div class="media">
            <a class="pull-left" href="/userpage">
                <img class="media-object" src="<?php echo $src; ?>" alt="Аватар пользователя">
            </a>

            <div class="media-body" style="padding-bottom: 2px;">
                <div class="id-status">
                    <span class="color-gray"># <?php echo isset($data->user->id) ? $data->user->id : 0 ;?></span>
<?php
                        if(isset($order->user))
                        {
//                            $color = $data->user->status == 1 ? " color-green" : " color-red";
//                            echo '<span class="user-status'.$color.'">';
//                            echo UserInfo::model()->getStatus($data->user->status);

                            $this->fio = $order->user->getFullName();
                            $this->email = $order->user->email;
                            $this->phone = isset($order->user->user_info) ? $order->user->user_info->phone : '';
                        }
                        else
                        {
                            $user_info = unserialize($order['user_info']);
                            $this->fio = $user_info['last_name'] .' '. $user_info['name'] . ' ' . $user_info['patronymic'];
                            $this->email = $user_info['email'];
                            $this->phone = $user_info['phone'];
                        }
?>
                </div>
                <div class="name">
                    <span class="icon-admin-user"></span> <?php echo $this->fio ;?>
                </div>
                <div class="email color-gray">
                    <i class="fa fa-envelope-o"></i> <?php echo $this->email ;?>
                </div>
                <div class="phone color-gray">
                    <span class="icon-admin-phone"></span> <?php echo $this->phone ;?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 o-status">
        <div class="color-gray font-12"><?php echo Yii::t('app', 'Order status') ;?></div>
        <div class="o-status-div" data-order="<?php echo $order->id ;?>">
<?php
            if ($order->status <= 0)
            {
                echo '<div data-toggle="tooltip" data-status="'.$order->status.'" data-placement="bottom" title="' . Orders::getStatus($order->status) . '" class="cursor-pointer big order-status' . $order->status . '"></div>';
            }
            elseif ($order->status == Orders::STATUS_COMPLETED)
            {
                echo '<div data-toggle="tooltip" data-status="'.$order->status.'" data-placement="bottom" title="' . Orders::getStatus($order->status) . '" class="cursor-pointer big order-status' . $order->status . ' ' . $order->status . '"></div>';
            }
            else
            {
                for ($i = Orders::STATUS_OK; $i <= Orders::STATUS_COMPLETED; $i++)
                {
                    echo '<div data-toggle="tooltip" data-status="'.$i.'" data-placement="bottom" title="' . Orders::getStatus($i) . '" class="cursor-pointer big order-status' . $i . ' ' . ($i > $order->status ? 'inactive' : '') . '"></div>';
                }
            }
?>
        </div>
    </div>
    <div class="col-md-2 font-12 time">
        <div class="color-gray">
<?php
            $flag = 0;
            if ($order->status != Orders::STATUS_COMPLETED && $order->status > 0)
            {
                $flag = 1;
                echo 'Осталось';
            }
            else
            {
                echo 'Завершен';
            }
?>
        </div>
<?php
        if ($flag)
        {
            echo '<div class="times">'.$order->f_delivery_end.'</div>';
        }
        else
        {
            $date = explode(' ', $order->f_update_time);
            if (isset($date[1]))
            {
                echo '<div class="times" data-toggle="tooltip" data-placement="bottom" title="' . $date[1] . '" >' . $date[0] . '</div>';
            }
        }
?>
    </div>
    <div class="col-md-2 font-12 time delivery">
        <div class="color-gray">Время доставки</div>
        <div class="times"><?php echo $order->f_delivery_time.', '.$order->delivery_hours ?></div>
    </div>
</div>
<div class="order-block row">
    <div class="tabs-block">
<?php
        $form = $this->beginWidget('BsActiveForm',
            array(
                'id' => 'orders-settings-form',
                'enableAjaxValidation' => false,
            )
        );

        $this->widget('BsNavs',
            array(
                'id' => 'orders_tabs',
                'items' => array(
                    array(
                        'label' => Yii::t('app', 'Order details'),
                        'id' => 'tab-details',
                        'active' => true,
                        'content' => $this->renderPartial('_tab-details', array('order' => $order, 'form' => $form, 'products' => $products), true)
                    ),
                    array(
                        'label' => 'Обработка заказа',
                        'id' => 'tab-common',
                        'active' => false,
                        'content' => $this->renderPartial('_tab-common', array('order' => $order, 'form' => $form, 'managers' => $managers, 'workers' => $workers), true)
                    ),
                    array(
                        'label' => Yii::t('app', 'Payment'),
                        'active' => false,
                        'content' => $this->renderPartial('_tab-payment', array('order' => $order, 'form' => $form), true)
                    ),
                    array(
                        'label' => 'Перенос заказа',
                        'active' => false,
                        'content' => $this->renderPartial('_tab-transfer', array('order' => $order,), true)
                    ),
                    array(
                        'label' => Yii::t('app', 'Refusal'),
                        'active' => false,
                        'content' => $this->renderPartial('_tab-refusal', array('order' => $order,), true)
                    ),
                    array(
                        'label' => Yii::t('app', 'Review'),
                        'active' => false,
                        'content' => $this->renderPartial('_tab-review', array('order' => $order,), true)
                    ),
                    array(
                        'label' => Yii::t('app', 'Event log'),
                        'active' => false,
                    ),
                ),
            )
        );
        $this->endWidget();
?>
        <form method="POST" class="copy" data-module="catalog">

        </form>
    </div>
</div>

<?php

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_status',
                'htmlOptions' => array(
                'class'=>'modal'
            ),
            'header'  => "Смена статуса",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_MODERATE.'" new-status="0" order="0" class="btn btn-danger change_status">Изменить</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>',
        )
    );

    $cs = Yii::app()->getClientScript();

    $cs->registerScript('changestatus',
        '
        $("#modal_status .change_status").on("click", function()
        {
            var id = $(this).attr("order");
            var status = $(this).attr("new-status");

            $.ajax(
            {
                type: "POST",
                url: "' . $this->createUrl('changeStatus') . '?id="+id+"&status="+status,
                success: function(msg)
                {
                    window.location.reload();
                }
            });
            return false;
        });
    ');

    $map = '
        $( document ).ready(function()
        {
            $("#orders_tabs").bind("shown.bs.tab", function (event, ui)
            {
                map.container.fitToViewport();
            })
        });
    ';

    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile('http://api-maps.yandex.ru/2.1/?lang='.Yii::app()->language);
    $cs->registerScript("map", $map);