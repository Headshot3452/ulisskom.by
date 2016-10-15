<?php
    class CartAction extends CAction
    {
        public function run()
        {
            $this->controller->setPageTitle('Корзина');

            $this->controller->breadcrumbs[] = $this->controller->pageTitle;

            $viewParams = array();

            Yii::import('application.models.cart.*');

            $steps = array(
                'cart' => array('model' => 'CartForm', 'scenario' => 'insert', 'view' => 'cart/cart'),
                'delivery' => array('model' => 'CartDeliveryForm', 'scenario' => 'insert', 'view' => 'cart/delivery'),
                'finish' => array('model' => 'CartFinishForm', 'scenario' => 'insert', 'view' => 'cart/finish'),
            );

            $load = false;

            $key_step = 'cart';

            if(Yii::app()->request->isAjaxRequest && isset($_POST['CartForm']['products']))
            {
                $user_id = null;
                if (!Yii::app()->user->isGuest)
                {
                    $user_id = Yii::app()->user->id;
                    $address_id = Address::model()->find('user_id = :user_id', array('user_id' => $user_id));
                }

                $order = new Orders();
                $order->user_id = $user_id;
//                var_dump($_POST);

                $status = Orders::createOrder($user_id, CJSON::decode($_POST['CartForm']['products']));

                yii::app()->end();
            }

//            if (isset($_POST['step']) && isset($steps[$_POST['step']]))
//            {
//                $key_step = $_POST['step'];
//            }
//            elseif (isset($_POST['back'])) //если кнопка назад
//            {
//                $load = true;
//                switch($key_step)
//                {
//                    case 'delivery': $key_step = 'cart'; break;
//                    case 'finish': $key_step = 'delivery'; break;
//                }
//            }

            $step = $steps[$key_step]; //выгружаем конфиг
            $model = new $step['model'];
            $model->scenario = $step['scenario'];

//            if (isset($_POST['step']))
//            {
//                $load == true;
//                if (isset($_POST[$step['model']]))
//                {
//                    $model->attributes = $_POST[$step['model']];
//                }
//                if ($key_step == 'cart')
//                {
//                    if ($model->validate())
//                    {
//                        $total_price = $model->getTotalProductsSum(); //общая сумма заказа
//                        $this->controller->setPageState($key_step, array_merge($_POST[$step['model']],array('total_price'=>$total_price)));
//                        $new_key_step = 'delivery';
//                    }
//                }
//                elseif ($key_step == 'delivery')
//                {
//                    if ($model->type_delivery != Orders::ORDER_DELIVERY_TO_ADDRESS)
//                    {
//                        $model->scenario = 'to_address';
//                    }
//                    if ($model->validate())
//                    {
//                        $this->controller->setPageState($key_step, $_POST[$step['model']]);
//                        $new_key_step = 'finish';
//                    }
//                }
//                elseif ($key_step == 'finish')
//                {
//                    if ($model->validate())
//                    {
//                        $cart = $this->controller->getPageState('cart');
//                        $delivery = $this->controller->getPageState('delivery');
//
//                        $user_id = null;
///                       if (!Yii::app()->user->isGuest)
//                        {
//                            $user_id = Yii::app()->user->id;
//                        }
//
//                        $status = Orders::createOrder(CJSON::decode($cart['products']), $delivery['type_delivery'], $delivery, $user_id);
//
//                        if ($status)
//                        {
//                            Yii::app()->user->setFlash('alert-swal', array(
//                                'header' => 'Ваш заказ принят',
//                                'content' => 'Следите за состоянием заказа в своем личном кабинете.',
//                            ));
//
//                            //кука для очистки корзины
//
//                            Yii::app()->request->cookies['refresh_cart'] = new CHttpCookie('refresh_cart', true);
//                            $this->refresh();
//                        }
//                        else
//                        {
//                            $model->addError('step', 'Заказ не оформлен, свяжитесь с администратором сайта');
//                        }
//                    }
//                }
//            }

            if (isset($new_key_step))
            {
                $key_step = $new_key_step;
                $step = $steps[$key_step];
                $model = new $step['model'];
            }

            if ($load == true)
            {
                $attributes = $this->controller->getPageState($key_step);
                if (!empty($attributes))
                {
                    $model->attributes = $attributes;
                }
            }

            if ($key_step == 'cart')
            {
                $model->cart = $this->controller->widget('application.widgets.CartWidget',array(),1);
            }

            if ($key_step == 'finish')
            {
                $model->finish = $this->controller->renderPartial('cart/_finish',
                    array(
                        'cart' => $this->controller->getPageState('cart'),
                        'delivery' => $this->controller->getPageState('delivery')
                    ),
                    1
                );
            }
            $model->step = $key_step;

            $content = $this->controller->renderPartial($step['view'], array_merge(array('model' => $model), $viewParams), 1);
            $this->controller->render('cart', array('content' => $content));
        }
    }