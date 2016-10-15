<?php
class StringToWidgetBehavior extends CBehavior
{
    /**
     * @var string $location
     * @var string $classSuffix
     */
    public $location='';
    public $classSuffix='';

    /**
     * @var array $allowWidgets
     */
    public $allowWidgets=array();

    /**
     * @param $content
     * @return string
     */
    public function decodeWidgets($content)
    {
        $content=preg_replace_callback('/\[\[w\:([^\]]+)\]\]/ims',array($this,'_parseWidget'),$content);
        return $content;
    }

    /**
     * @param $widget
     * @return string
     */
    protected  function _parseWidget($widget)
    {
        $html='';
        $params=explode('|',$widget[1]);


        if (in_array($params[0],$this->allowWidgets))
        {
            $html=$this->_loadWidget($params[0],(isset($params[1]) ? $params[1] : ''),(isset($params[2]) ? $params[2] : null));
        }

        return $html;
    }

    /**
     * @param $class
     * @return string
     */
    protected function _getFullClassName($class)
    {
        return $this->location.'.'.$class.$this->classSuffix;
    }

    /**
     * @param $class
     * @param string $attributes
     * @param null $cache
     * @return string
     */
    protected function _loadWidget($class,$attributes='',$cache=null)
    {
        $html='';
        $attributes=$this->_parseAttributes($attributes);

        $index = 'widget_'.$class.'_'.serialize($attributes);


        if ($cache && $cachedHtml = Yii::app()->cache->get($index))
        {
            $html = $cachedHtml;
        }
        else
        {
            ob_start();

            $widgetClass=$this->_getFullClassName($class);

            $widget = Yii::app()->getWidgetFactory()->createWidget($this->owner, $widgetClass, $attributes);

            $widget->init();
            $widget->run();


            $html=ob_get_contents();
            ob_get_clean();

            if ($cache)
            {
                Yii::app()->cache->set($index, $html, $cache);
            }
        }

        return $html;
    }

    /**
     * @param $params
     * @return array
     */
    protected function _parseAttributes($params)
    {
        $attributes=array();

        $attr=explode(';',$params);
        $count=count($attr);

        for ($i=0;$i<$count;$i++)
        {
            $attr_val=explode('=',$attr[$i]);
            if (isset($attr_val[1]))
            {
                $attributes[$attr_val[0]]=$attr_val[1];
            }
        }

        return $attributes;
    }
}