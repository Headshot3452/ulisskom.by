<?php
    class BackendHelper
    {
        /**
         * @param $title
         * @param null $link
         * @return string
         */

        public static function htmlTitleBlockDefault($title, $link=null, $folder = '')
        {
            $result = (($link!=null) ? " ".CHtml::link('<span class="pull-left fa fa-angle-left"></span> ',$link) : "");
            $result .= (($folder!=null) ? " ".'<span class="pull-left '.$folder.'"></span> ' : "");
            $result .= (($title!='') ? " ".'<span class="pull-left title">'.$title.'</span>' : "");

            return $result;
        }
    }