<?php

Yii::import('bootstrap.widgets.BsListView');

class ProductListView extends BsListView
{
    public $typeCatalog='small';
    public $counterCssClass='counter';
    public $sorter='title_asc';
    public $counts=array('10'=>'10','20'=>'20','40'=>'40','50'=>'50');

    public function renderMainItems()
    {
        if ($this->dataProvider->getItemCount()>0)
        {
            echo '<div class="type-catalog">
            <a href="?type=small" class="'.($this->typeCatalog=='small'?'active':"").'"><span class="glyphicon glyphicon-list"></span> Кратко</a>
            <a href="?type=full" class="'.($this->typeCatalog=='full'?'active':"").'"><span class="glyphicon glyphicon-align-justify"></span> Подробно</a>
        </div><div class="clearfix"></div>';

            switch($this->typeCatalog)
            {
                case 'small':
                    echo '<div class="row header">
                            <div class="col-xs-1">№</div>
                            <div class="col-xs-1">Артикул</div>
                            <div class="col-xs-4">Наименование</div>
                            <div class="col-xs-2">Цена</div>
                            <div class="col-xs-2">Наличие</div>
                            <div class="col-xs-2"></div>
                        </div>';
                    break;
                case 'full':
                    echo '<div class="row header">
                            <div class="col-xs-8">Наименование</div>
                            <div class="col-xs-4"></div>
                        </div>';
                    break;
            }

            parent::renderItems();
        }
    }

    public function renderMainSorter()
    {
        $this->sorter = Yii::app()->request->cookies['sort_products'] ? Yii::app()->request->cookies['sort_products']->value : 'title_asc';
        $count=$this->dataProvider->getItemCount();
        if ($count>0)
        {
            $cs=Yii::app()->getClientScript();
            $sorter='
                    $("body").on("change","#sort-main",function()
                    {
                        $.cookie("sort_products",$(this).val(),{expires: 3600, path: "/"});
                        window.location.reload();
                    });
                ';
            $cs->registerPackage("cookie")->registerScript('sorter',$sorter);

            echo CHtml::dropDownList('sort-main',$this->sorter,array('price_asc'=>'Сначала дешевые','price_desc'=>'Сначала дорогие','title_asc'=>'От А-Я','title_desc'=>'От Я-А'),array('prompt'=>'Сортировать:','class'=>$this->sorterCssClass));;
        }
    }

    public function renderCounter()
    {
        $counter=$this->dataProvider->pagination->pageSize;
        $count=$this->dataProvider->getItemCount();
        if ($count>0)
        {
            $cs=Yii::app()->getClientScript();
            $scr='
                    $("body").on("change", "#count-main",function()
                    {
                        $.cookie("count",$(this).val(),{expires: 3600, path: "/"});
                        window.location.reload();
                    });
                ';
            $cs->registerPackage("cookie")->registerScript('counter',$scr);

            echo CHtml::dropDownList('count-main',$counter,$this->counts, array('class'=>$this->counterCssClass));
        }
    }
}
