<?php
class CarouselGalleryWidget extends StructureWidget
{
    public $size='small';
    public $view = 'gallery';
    public $gallery_id;
    protected  $_items=array();

    public function setData()
    {
        $this->_items=GalleryImages::getItemsByGalleryId($this->gallery_id);

        if (empty($this->_items))
        {
            return false;
        }
        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view);
    }

}