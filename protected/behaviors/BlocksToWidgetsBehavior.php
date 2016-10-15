<?php
class BlocksToWidgetsBehavior extends StringToWidgetBehavior
{
    protected $_blockWidgets=array();


    public function setBlockWidgets($blocks)
    {
        $this->_blockWidgets=$blocks;
    }

    /**
     * @param $content
     * @return string
     */
    public function decodeBlocks($content)
    {
        $content=preg_replace_callback('/\[\[b\:([^\]]+)\]\]/ims',array($this,'_parseBlock'),$content);
        return $content;
    }

    protected function _parseBlock($block)
    {
        $html='';

        list($name,$params)=explode('|',$block[1]);

        if ($name && isset($this->_blockWidgets[$name]))
        {
            $widgets=$this->_blockWidgets[$name];
            foreach ($widgets as $widget)
            {
                $widget->settings .= 'id='.$widget->tree_id.';';//дописываем в настройки id категории
                $widget->settings .= 'view='.$widget->view;

                $widget_params=explode('|',$widget->settings);

                $html.=$this->_loadWidget($widget->widget->name,
                    (isset($widget_params[0]) ? $widget_params[0] : ''),(isset($widget_params[1]) ? $widget_params[1] : null));
            }
        }
        return $html;
    }
}