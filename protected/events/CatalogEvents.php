<?php
/**
 * Created by PhpStorm.
 * User: Ridnlee
 * Date: 16.02.2015
 * Time: 9:45
 */

class CatalogEvents {

    public static  $oldParentsIds = array();

    public static function BeforeMoveCatalogTree($event)
    {
        $sender=$event->sender;

        $parents = $sender->getParents();

        //сохраняем старые родительские категории
        self::$oldParentsIds = CHtml::listData($parents,'id','id');
    }

    public static function AfterMoveCatalogTree($event)
    {
        $sender = $event->sender;

        $new_parents = CHtml::listData($sender->getParents(),'id','id');

        $descendants = CHtml::listData($sender->descendants()->findAll(),'id','id');//находим дочерние категории
        $descendants[$sender->id] = $sender->id;//добваляем к дочерним и текущую директорию

        //сверяем какие родительские категории изменились и удаляем параметры отсутствующих категорий  у товаров
        foreach(self::$oldParentsIds as $parent)
        {
            //если удалилась категория, то ищем ее параметры
            if(!isset($new_parents[$parent]))
            {
                $params = CatalogParams::model()->findAll('catalog_tree_id = :tree_id',array('tree_id'=>$parent));
                //если параметры есть, то удаляем их из товаров дочерних категорий
                if($params)
                {
                    $params_ids = CHtml::listData($params, 'id', 'id');
                    CatalogProductsParams::deleteProductParams($params_ids, $descendants);
                }
            }
        }

        //выбираем новые параметры
        $params = CatalogParams::getTreeParams($descendants);
        $params = array_combine(CHtml::listData($params,'id','id'),$params);

        foreach($params as $param)
        {
            //если параметр относился к группе принадлежащей старому родительскому разделу, то удаляем ссылку на родителя
            if($param->parent_id && !isset($params[$param->parent_id]))
            {
                $param->parent_id  = null;
                $param->save();
            }
        }

    }

}