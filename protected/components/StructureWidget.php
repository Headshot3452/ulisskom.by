<?php
class StructureWidget extends Portlet
{
    public $active_id=null;
    public $children=false;
    public $type=null;
    public $view='view'; //по умолчанию имя шаблона

    public function init()
    {
        $data=true;

        if ($this->active_id!==null)
        {
            if (($this->children==false && $this->controller->active_id!=$this->active_id) //только для текущей
                || ($this->children==true && (($this->type==null) ? !$this->controller->hasActive($this->active_id) : !$this->controller->hasActive($this->active_id,$this->type)))) // и для дочерних
            {
                $this->visible=false;
                $data=false;
            }
        }

        if ($data)
        {
            if (!$this->setData())
            {
                $this->visible=false;
            }
        }

        parent::init();
    }

    /*
     * Метод для заполнение данными виджета (можно было абстрактным сделать, но не надо)
     *
     * */
    public function setData()
    {
        return true;
    }
}