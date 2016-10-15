<?php
Yii::import('zii.widgets.CMenu');
class MenuCheckbox extends CMenu
{
    protected function renderMenuItem($item)
	{
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
            return CHtml::checkBox($item['name'],$item['active'],array('value'=>$item['value'])).' '.$label;
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}
    
    protected function renderMenu($items)
    {
        parent::renderMenu($items);
        
        $cs=Yii::app()->clientScript;
        
        $left_menu_checkbox='
                    (function($)
                    {
                        var id_left_menu="left-menu";
                        
                        addToMenuUrl(getChekboxUrl());
                        
                        $("#'.$this->id.' input[type=checkbox]").click(function()
                         {
                            var browser_url = getMainUrl();
                            var obj=$("#"+id_left_menu+" li a");
                            var checkbox=$(this);
                            $.each(obj,function(key,value)
                            {
                                item=obj.eq(key);
                                url_prev="&";
                                url=checkbox.attr("name")+"="+checkbox.attr("value");
                                if (checkbox.is(":checked"))
                                {
                                    type="add";
                                }
                                else 
                                {
                                    type="delete";
                                }
                                item.attr("href",setUrl(type,item.attr("href"),url_prev+url));
                                 
                                //меняем если get пустой при добавлении (костыль- http://site.by/?&params=param)
                                regexp=new RegExp("\\\?");
                                if (!regexp.test(browser_url) && type=="add")
                                {
                                    url_prev="?"+url_prev;
                                }
                                history.pushState( null, null, setUrl(type,browser_url,url_prev+url));
                            });
                            getPage();
                         })
                         
                            //чтобы включить ajax меню. только сделать активность меню
//                         $("#"+id_left_menu+" li a").click(function()
//                         {
//                            history.pushState( null, null, $(this).attr("href"));
//                            getPage();
//                            return false;
//                         });
                         
                         function getChekbox()
                         {
                            array=[];
                            var obj=$("#'.$this->id.' input[type=checkbox]:checked");
                            $.each(obj,function(key,value)
                            {
                                item=obj.eq(key);
                                temp={name:item.attr("name"),value:item.attr("value")};
                                array.push(temp);
                            });
                            return array;
                         }
                         
                         function getChekboxUrl()
                         {
                            url="";
                            var obj=$("#'.$this->id.' input[type=checkbox]:checked");
                            $.each(obj,function(key,value)
                            {
                                item=obj.eq(key);
                                url+="&"+item.attr("name")+"="+item.attr("value");
                            });
                            return url;
                         }
                         
                         function addToMenuUrl(url)
                         {
                            var obj=$("#"+id_left_menu+" li a");
                            $.each(obj,function(key,value)
                            {
                                item=obj.eq(key);
                                item.attr("href",item.attr("href")+url);
                            });
                         }
                         
                         function getAjax()
                         {
                             browser_url=history.location.href || document.location.href;
                         }
                         
                         function setUrl(type,url,str)
                         {
                            new_url="";
                            switch(type)
                            {
                                case "add": new_url=url+str; break;
                                case "delete": new_url=url.replace(str,""); break;
                            }
                            return new_url;
                         }
                         
                        function getPage()
                        {
                            url=getMainUrl();
                            $.ajax(
                            {
                                url:url,
                                type:"GET",
                                success: function(data)
                                {
                                    $(".right-content-block").html(data);
                                }
                            }
                            );
                        }
                        
                        function getMainUrl()
                        {
                            return history.location.href || document.location.href;
                        }
                         
                    })(jQuery);
                ';
        $cs->registerPackage('jquery')->registerScriptFile(Yii::app()->assetManager->publish(Yii::app()->baseUrl.'js/history.min.js'))->registerScript('left_menu_checkbox',$left_menu_checkbox);
    }
}
?>
