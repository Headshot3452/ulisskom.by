<?php

    /*
     *  $this->widget('application.widgets.PopupFormWidget', array(
            'element'=>'$("#'.$id.'")',
            'title'=>'Права доступа:',
            'items'=>$right['rights'],
            'select'=>$right['group_rights'],
            'action'=>$this->createUrl('ajax/company-edit-group-rights'),
            'type'=>'check'
        ));
     */

class PopupFormWidget extends Portlet{

    public $element = '$(".item")'; //Элемент, по клику на который всплывает окно
    public $show = false;//всплыть элемент при загрузке страницы
    public $title = 'Title'; //заголовок всплывающего окна
    public $items = array(); // список элементов ключ=>значение
    public $select = ''; //ключ выбранного элемента или массив ключей
    public $action = ''; // куда посылать данные
    public $type='list'; //list or check, тип списка
    public $htmlOptions = array(); //опции для всплывающего окна (id,class)
    public $placement = 'right';// расположение окна относительно элемента
    public $inputName = 'items';//имя чекбоксов или списка
    public $checkboxName = 'rewrite';//имя чекбокса перед кнопками
    public $checkboxLabel = '';//если ничего не пришло, то чекбокса нет
    public $ajaxOptions = array();// опции отправки аяксом, типа если пустой массив, значит опции по умолчанию, а если типа false, то не надо аякса нам
    public $ajax_success = '';//js который будет выполняться при успешном выполнении скрипта


    protected function renderContent()
    {
        if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

        if(!isset($this->htmlOptions['class']))
        {
            $this->htmlOptions['class'] = 'popover popup-form';
        }
        else
        {
            $this->htmlOptions['class'] .= 'popover popup-form';
        }

        //ид блока, откуда берется содержимое формы для поповера
        $contentId = 'cont'.$this->htmlOptions['id'];

        //формируем содержимое окна
        $content = Chtml::form($this->action);

        //генерируем список или чекбоксы в зависимости от типа
        if($this->type == 'list')
        {
            $type = 'list';
            $content .= CHtml::dropDownList($this->inputName, $this->select, $this->items, array('size'=>5) );
        }
        else
        {
            $type = 'check';
            $content .= '<div class="popup-form-content">';
            $content .= CHtml::checkBoxList($this->inputName, $this->select, $this->items,array('template'=>'<div class="item-container"> {input} {label} </div>','separator'=>''));
            $content .= '</div>';
        }

        $button_options = array(
            'type'=>'primary',
            'buttonType'=>'ajaxSubmit',
            'label'=>'Сохранить',
            'url'=>$this->action,
        );
        //если отправка аяксом
        if($this->ajaxOptions===array())
        {
             $button_options['ajaxOptions'] = array(
                    'dataType'=>'json',
                    'type'=>'POST',
                    'beforeSend' => 'function(){
                     }',
                    'success' => 'js:function(data){

                       alert(data.message);
                       if(data.status=="ok")
                       {
                            var form_block = $(".popup-form[for='.$contentId.']").eq(0);
                            var content_block = $("#'.$contentId.'")
                            content_block.html("").append(form_block.clone());
                            '.$this->ajax_success.'

                            $("[rel=\"popover\"]").popover("hide");
                       }

                    }',
                    'error' => 'function(data){
                       alert("Не удалось выполнить действие");
                    }',
                );

        }
        elseif($this->ajaxOptions===false)
        {
            $button_options['buttonType'] = 'submit';
        }
        else
        {
            $button_options['ajaxOptions'] = $this->ajaxOptions;
            $button_options['buttonType'] = 'ajaxSubmit';
        }

        $content .= '<div class="popup-form-footer">';
        if($this->checkboxLabel)
        {
            $content .= '<div class="item-container">';
            $content .= Chtml::checkBox($this -> checkboxName,false, array('id'=>$this -> checkboxName));
            $content .= Chtml::label($this -> checkboxLabel,$this -> checkboxName);
            $content .= '</div>';
        }
        $content .= $this->widget('bootstrap.widgets.TbButton', $button_options,true);
        $content .= '</div>';

        $content .= Chtml::endForm();

        echo '<div style="display:none;" id="'.$contentId.'">'.$content.'</div>';
        $cs = Yii::app()->getClientScript();
        $cs->registerScript('popupwidget'.$this->htmlOptions['id'],$this->element.'.popover({placement:"'.$this->placement.'",title:"'.$this->title.'",html:true,template:\'<div class="'.$this->htmlOptions['class'].'" for="'.$contentId.'"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>\',
                     content:function(){
                           return $("#'.$contentId.' form").eq(0).clone();
                        } });
                        '.($this->show?$this->element.'.popover("show")':'').';
                        ');
    }

}
