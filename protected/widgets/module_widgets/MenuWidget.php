<?php
    class MenuWidget extends StructureWidget
    {
        public $view = 'custom';
        public $encodeLabel = false;
        public $id = null; // root меню
        public $css_class = ''; //классы для меню
        public $menu_type = 'navbar'; // menu/navbar/tree
        public $dropdown = true; //делать подменю выпадающимим списками

        protected  $_items=array();

        public function setData()
        {
            $items_key = $this->menu_type == 'tree' ?  'children' : 'items';
            $this->_items = $this->controller->getMenu($this->id, $items_key);

            if (empty($this->_items))
            {
                return false;
            }
            return true;
        }

        public function renderContent()
        {
            if($this->menu_type == 'menu')
            {
                $this->controller->widget('zii.widgets.CMenu',
                    array(
                        'items' => $this->_items,
                        'encodeLabel'=> $this->encodeLabel,
                        'htmlOptions' => array('class' => $this->css_class)
                    )
                );
            }
            elseif($this->menu_type == 'navbar')
            {
                $this->widget('bootstrap.widgets.BsNav',
                    array(
                        'items' => $this->_items,
                        'encodeLabel'=> $this->encodeLabel,
                        'htmlOptions' => array('class' => $this->css_class)
                    )
                );
            }
            elseif($this->menu_type == 'tree')
            {
                $this->widget('system.web.widgets.CTreeView',
                    array(
                        'data' => $this->_items,
                        'encodeLabel'=> $this->encodeLabel,
                        'htmlOptions' => array('class' => $this->css_class)
                    )
                );
            }
            elseif($this->menu_type == 'custom')
            {
                $this->render(get_class().'/'.$this->view);
            }
        }

        public static function getView()
        {
            return array('navbar' => 'По умолчанию');
        }
    }