<?php
class CartProductsValidator extends CValidator
{
    protected function validateAttribute($object,$attribute)
    {
        $value=CJSON::decode($object->$attribute);

        if (!empty($value))
        {
            foreach($value as $item)
            {
                $product=CatalogProducts::model()->active()->findByPk($item['id']);
//                if (!$product || $product->count==0)
                if (!$product)
                {
                    $this->addError($object,$attribute,'Вы сейчас не можете заказать товар '.$item['title']);
                }
                elseif($product->price!=$item['price'])
                {
                    $item['price']=$product->price;
                    $this->addError($object,$attribute,'Изменилась цена на '.$item['title']);
                }
//                elseif($product->count<$item['count'])
//                {
//                    $item['count']=$product->count;
//                    $this->addError($object,$attribute,'Вы можете заказать только '.$item['count'].' '.$item['title']);
//                }
                $item['title']=addcslashes($item['title'],'"');
                $result[]=$item;
            }

            //записываем актуальные данные
            $cs=Yii::app()->getClientScript();
            $cs->registerPackage("jstorage")->registerScript('cart-update-data',
                '$.jStorage.set("cart",\''.CJSON::encode($result).'\');'
            );
        }
    }
}