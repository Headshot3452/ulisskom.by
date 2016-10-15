<?php

class CartSimpleAction extends CAction
{
    public function run()
    {
        $this->controller->setPageTitle('Корзина товаров');
        $this->controller->breadcrumbs[]= 'Корзина';

        Yii::import('application.models.cart.*');

        $key_step='cart';

        $model_cart = new CartForm();
        $model_delivery = new CartDeliveryForm();
        $model_delivery->type_delivery = Orders::ORDER_DELIVERY_NOT_ADDRESS;


        if (isset($_POST['step']))
        {


            if(isset($_POST['CartForm']))
                $model_cart->attributes = $_POST['CartForm'];

            if(isset($_POST['CartDeliveryForm']))
                $model_delivery->attributes = $_POST['CartDeliveryForm'];

            if($model_delivery->type_delivery == Orders::ORDER_DELIVERY_TO_ADDRESS)
                $model_delivery->scenario = 'to_address';

//            print_r($model_delivery);exit;

            if ($model_cart->validate() && $model_delivery->validate())
            {
                $user_id=null;
                if (!Yii::app()->user->isGuest)
                {
                    $user_id=Yii::app()->user->id;
                }

                $order = Orders::createOrder(CJSON::decode($model_cart->products), $model_delivery->type_delivery, $model_delivery->attributes, $user_id);

                if ($order)
                {
                    $key_step = 'finish';
                    Yii::app()->request->cookies['refresh_cart'] = new CHttpCookie('refresh_cart', true);
                }
                else
                {
                    $model_cart->addError('step', 'Заказ не оформлен, свяжитесь с администратором сайта');
                }
            }
        }

        if ($key_step=='cart')
        {
            $model_cart->cart = $this->controller->widget('application.widgets.CartWidget',array(),1);
            $this->controller->render('simple_cart/cart',array('model_cart'=>$model_cart,'model_delivery'=>$model_delivery));
        }
        else
        {
            $this->controller->render('simple_cart/finish',array('order'=>$order));
        }


    }

}