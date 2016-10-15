<?php
class BannerDescriptionWidget extends StructureWidget
{
    public $size='small';
    public $banner_id;
    public $view = 'banner';
    protected $_banner;

    public function setData()
    {
        $this->_banner=Banners::getBanner($this->banner_id);

        if (empty($this->_banner))
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