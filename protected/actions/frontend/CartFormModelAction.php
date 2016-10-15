<?php
    class CartFormModelAction extends CAction
    {
        public function run()
        {
            $this->controller->setPageTitle('Корзина');

            $this->controller->breadcrumbs[] = $this->controller->pageTitle;

            Yii::import('application.models.cart.*');

            $steps = array(
                'cart' => array('form' => 'cart.cart', 'scenario' => 'insert', 'view' => 'cart_form/cart'),
                'payment' => array('form' => 'cart.payment', 'scenario' => 'insert', 'view' => 'cart_form/cart'),
                'delivery' => array('form' => 'cart.delivery', 'scenario' => 'insert', 'view' => 'cart_form/cart'),
                'finish' => array('form' => 'cart.finish', 'scenario' => 'insert', 'view' => 'cart_form/cart'),
            );

            $key_step = 'cart';

            $load = false;

            if (isset($_POST['FormModel']['step']) && isset($steps[$_POST['FormModel']['step']]))
            {
                if (Yii::app()->user->isGuest)
                {
                    Yii::app()->user->setFlash('modal',
                        array(
                            'header' => 'Невозможно офрмить заказ',
                            'content' => 'Для продолжения оформления заказа требуется авторизоваться',
                        )
                    );
                    $this->refresh();
                    Yii::app()->end();
                }

                $key_step = $_POST['FormModel']['step'];
            }

            if (isset($_POST['back'])) //если кнопка назад
            {
                $load = true;
                switch($key_step)
                {
                    case 'payment': $key_step = 'cart'; break;
                    case 'delivery': $key_step = 'payment'; break;
                    case 'finish': $key_step = 'delivery'; break;
                }
            }

            $step = $steps[$key_step]; //выгружаем конфиг
            $model = new FormModel($step['scenario'], 'application.forms.'.$step['form']);
            $form = $model->getForm();

//            if ($form->submitted('step') && !Yii::app()->user->isGuest) //если нажали вперед
//            {
//                if ($key_step == 'cart')
//                {
//                    if ($form->validate())
//                    {
//                        $this->controller->setPageState($key_step, $_POST[$model->model]);
//                        $new_key_step = 'payment';
//                    }
//                }
//                elseif($key_step == 'delivery')
//                {
//                    if ($model['type_delivery'] == 2)
//                    {
//                        $model->setScenario('to_address');
//                    }
//                    if ($form->validate())
//                    {
//                        $this->controller->setPageState($key_step, $_POST[$model->model]);
//                        $new_key_step = 'finish';
//                    }
//                }
//                elseif($key_step == 'payment')
//                {
//                    if ($form->validate())
//                    {
//                        $this->controller->setPageState($key_step, $_POST[$model->model]);
//                        $new_key_step = 'delivery';
//                    }
//                }
//                elseif($key_step == 'finish')
//                {
//                    if ($form->validate())
//                    {
//                        $cart = $this->controller->getPageState('cart');
//                        $address = $this->controller->getPageState('delivery');
//                        $payment = $this->controller->getPageState('payment');
//
//                        $status = Orders::createOrder(CJSON::decode($cart['products']), $payment['type_payment'], $address, Yii::app()->user->id);
//
//                        if ($status)
//                        {
//                            Yii::app()->user->setFlash('modal',
//                                array(
//                                    'header'=>'Заказ принят',
//                                    'content'=>'Спасибо Ваш заказ принят.',
//                                )
//                            );
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
                $model = new FormModel($step['scenario'], 'application.forms.'.$step['form']);
                $form = $model->getForm();
                $attributes = $this->controller->getPageState($key_step);
                $load=true;
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
//                $model->cart = $this->controller->widget('application.widgets.CartWidget',array(),1);
    //            $form->elements['cart']->content=$this->controller->widget('application.widgets.CartWidget',array(),1);
            }

            if ($key_step == 'delivery')
            {
    //            $models=Address::getUserAddress(Yii::app()->user->id);
    //            $checked=$model->address_id;
    //            foreach($models as $item)
    //            {
    //                $check=false;
    //                if ($checked!="")
    //                {
    //                    if ($checked==$item->id)
    //                    {
    //                        $check=true;
    //                    }
    //                }
    //                elseif($item->default==Address::ADDRESS_DEFAULT)
    //                {
    //                    $check=true;
    //                }
    //
    //                $form->elements['address']->content .= CHtml::radioButton('FormModel[address_id]',$check,array('value'=>$item->id));
    //                $form->elements['address']->content .=$this->renderPartial('//profile/_address_item',array('data'=>$item),1);
    //            }
            }

            if ($key_step == 'finish')
            {
                $form->elements['finish']->content = $this->controller->renderPartial('cart_form/_finish',
                    array(
                        'cart' => $this->controller->getPageState('cart'),
                        'payment' => $this->controller->getPageState('payment'),
                        'delivery' => $this->controller->getPageState('delivery')
                    ),
                    1
                );
            }

            $form->stateful = true;

            $form->elements['step']->value = $key_step;
    //        $this->controller->render($step['view'],array('form'=>$form,'model'=>$model));

            $this->controller->render('cart/cart_info', array('form' => $form, 'model' => $model));
        }
    }