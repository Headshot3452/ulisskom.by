<?php
class MapWidget extends StructureWidget
{
    public $view='map';
    public $width='100%';
    public $height='100%';
    public $map_id;
    public $group=false;

    protected $_data;

    public function setData()
    {
        $this->_data=Maps::model()->with('mapsPlacemarks')->findByPk($this->map_id);

        if (empty($this->_data))
        {
            return false;
        }
        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view);
    }

    public static function getView()
    {
        return array('map'=>'По умолчанию');
    }
}