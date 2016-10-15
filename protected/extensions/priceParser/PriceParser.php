<?php
class PriceParser extends CComponent
{
    public $root_id=1;
    protected $_root;

    protected $_category_ids=array();
    protected $_products_ids=array();

    public function init()
    {
        $this->_root=CatalogTree::model()->roots()->findByPk($this->root_id);

        if (!$this->_root)
            throw new CException('Root no exist');

        $products=Yii::app()->db->createCommand("SELECT `t`.`id` FROM `catalog_products` `t` WHERE `t`.`status`!=".CatalogProducts::STATUS_DELETED)->queryAll();

        $count=count($products);

        for($i=0;$i<$count;$i++)
        {
            $this->_products_ids[$products[$i]['id']]=true;
        }
    }

    public function getCsv()
    {
        $categories=$this->getDataCategories();

        ob_start();
        $count=count($categories);
        for($i=0;$i<$count;$i++)
        {
            echo str_repeat('!',$categories[$i]['level']-1).';'.$categories[$i]['title'].';'.$categories[$i]['status']."\r\n";
            echo $this->getProductsString($categories[$i]['id']);
        }
        $content=ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function getProductsString($category_id)
    {
        $c=array(
            'id'=>0,
            'title'=>1,
            'pack'=>2,
            'price'=>3,
            'price_opt'=>3,
            'status'=>4,
        );

        $products=Yii::app()->db->createCommand("SELECT `t`.`id`,`t`.`title`,`t`.`price`,`t`.`status` FROM `catalog_products` `t` WHERE `t`.`parent_id`='".$category_id."' and `t`.`status`!=".CatalogProducts::STATUS_DELETED)->queryAll();
        ob_start();
        $count=count($products);
        for($i=0;$i<$count;$i++)
        {
            $item[$c['id']]=$products[$i]['id'];
            $item[$c['title']]=$products[$i]['title'];
            $item[$c['price']]=$products[$i]['price'];
            $item[$c['status']]=$products[$i]['status'];

            ksort($item);

            echo implode(';',$item)."\r\n";
        }
        $content=ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @param $path
     */
    public function parseCsv($path)
    {

        $c=array(
            'id'=>0,
            'title'=>1,
            'category_status'=>2,
            'price'=>2,
            'price_opt'=>2,
            'status'=>3,
        );

        $parents=array();
        $level=0;
        $count=0;


        $categories=$this->getCategories();

        self::encodingFile($path);
        
        $file=file($path);

//        var_dump($file);

        $transaction = Yii::app()->db->beginTransaction();

        try
        {

            foreach ($file as $row)
            {
                $values=explode(';', $row);

                if (isset($values[$c['price_opt']]) && $values[$c['title']]!='')
                {
                    if ((int)$values[$c['id']] == 0)
                    {
                        $temp_level=substr_count($values[$c['id']],'!');

                        if ($temp_level==$level)
                        {
                            array_pop($parents);
                        }
                        elseif($temp_level<$level)
                        {
                            $parents=array_slice($parents,0,$temp_level-1);
                        }

                        $level=$temp_level;


                        if (isset($values[$c['category_status']]) && $values[$c['category_status']]!='')
                        {
                            $status=$values[$c['category_status']];
                        }
                        else
                        {
                            $status=CatalogTree::STATUS_OK;
                        }

                        $parents[]=$this->getCategoryId($categories,$parents,$values[$c['title']],$status);
//                        var_dump($parents);

                        $count=count($parents);
                        continue;
                    }
                }

                if ($count > 0)
                {
                    $parent = $parents[$count - 1];
                    $this->getProduct($parent, $values, $c);
                }
            }

            $this->deactivateCategory();
            $this->deactivateProducts();

            $transaction->commit();
        }
        catch(Exception $e)
        {
            $transaction->rollback();

            throw new CException($e->getMessage());
        }
    }

    public function getCategories()
    {
        $categories=$this->getDataCategories();

        $stack=array('0'=>array());
        $level=1;
        $parent=1;
        $last=0;

        foreach($categories as $category)
        {
            $this->_category_ids[$category['id']]=true;

            $item=array('title'=>$category['title'],'parent'=>$parent,'children'=>array()); //element с предворительныь родителем
            $stack[$category['id']]=$item;

            if ($category['level']!=$level)
            {
                if ($category['level']>$level) //если уровень возврастает
                {
                    $parent=$last; //родитель последний
                }
                else
                {
                    $parent=$stack[$item['parent']]['parent']; //ищим родителя родителя
                }

                $stack[$category['id']]['parent']=$parent;

                $level=$category['level']; //меняме уровень
            }
            $last=$category['id']; //последний элимент

            $stack[$parent]['children'][$category['id']]=&$stack[$category['id']]; //ссыдка на дочерний элимент
        }

        return (!empty($stack) && isset($stack[0]['children'])) ? $stack[0]['children'] : array();
    }

    public function getDataCategories()
    {
        return Yii::app()->db->createCommand("SELECT `t`.`id`,`t`.`title`,`t`.`name`,`t`.`level`,`t`.`status` FROM `catalog_tree` `t` WHERE `t`.`status`!='".CatalogTree::STATUS_DELETED."' and `t`.`language_id`='".Yii::app()->controller->getCurrentLanguage()->id."' and `t`.`root`='".$this->root_id."' and `t`.`lft`!='1' ORDER BY  t.`lft` ")->queryAll();
    }

    public function getCategoryId(&$categories,$parents,$title,$status)
    {
        $stack=&$categories;
        $count=count($parents);
        for($i=0;$i<$count;$i++)
        {
            if (isset($stack[$parents[$i]]))
            {
                $stack=&$stack[$parents[$i]]['children'];
            }
            else
            {
                throw new CException();
            }
        }

        foreach($stack as $key=>$item)
        {
            if ($item['title'] == $title)
            {
                Yii::app()->db->createCommand("UPDATE `catalog_tree` SET `status`='".$status."' WHERE `id`='".$key."'")->execute();
                unset($this->_category_ids[$key]);
                return $key;
            }
        }

        $id=$this->insertTree($parents,$title);


        $stack[$id]=array('title'=>$title,'children'=>array());

        return $id;
    }

    public function insertTree($parents,$title)
    {
        $count=count($parents);

        $category=new CatalogTree();
        $category->title=$title;
        $category->status=CatalogTree::STATUS_OK;

        if ($count>0)
        {
            $parent=CatalogTree::model()->findByPk($parents[$count-1]);
            $category->appendTo($parent);
        }
        else
        {
            $category->appendTo($this->_root);
        }

        return $category['id'];
    }

    public function getProduct($parent_id,$values,$config)
    {
        $product = CatalogProducts::model()->notDeleted()->findByAttributes(array('parent_id' => $parent_id, 'title' => $values[$config['title']]));

        if (!$product)
        {
            $product = new CatalogProducts();
            $product->parent_id = $parent_id;
            $product->title = $values[$config['title']];
        }
        else
        {
            unset($this->_products_ids[$product->id]);
        }
        $product->price = (int)$values[$config['price']];

        $product->status = CatalogProducts::STATUS_OK;

        if (isset($values[$config['status']]) && $values[$config['status']]!='')
        {
            $product->status = (int)$values[$config['status']];
        }

        $product->save();
    }

    public static function encodingFile($file,$in_charset='windows-1251',$out_charset='utf-8')
    {
        $content=file_get_contents($file);
        $handle=fopen($file, 'w');
        fwrite($handle,iconv($in_charset,$out_charset.'//IGNORE',$content));
        fclose($handle);
    }

    public function deactivateCategory()
    {
        if (!empty($this->_category_ids))
        {
            $command = Yii::app()->db->createCommand();
            $command->update('catalog_tree',
                array(
                    'status'=>CatalogTree::STATUS_NOT_ACTIVE,
                ),
                array('in', 'id', array_keys($this->_category_ids))
            );
        }
    }

    public function deactivateProducts()
    {
        if (!empty($this->_products_ids))
        {
            $command = Yii::app()->db->createCommand();
            $command->update('catalog_products',
                array(
                    'status'=>CatalogProducts::STATUS_NOT_ACTIVE,
                ),
                array('in', 'id', array_keys($this->_products_ids))
            );
        }
    }
}