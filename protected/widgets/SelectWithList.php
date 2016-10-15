<?php

class SelectWithList extends Portlet{

    /*
     * array('dropdown_items'=>array(
     *       'M' => 'Male',
     *       'F' => 'Female'
     *      ),
     *
            'list_items'=>array(
                array('label'=>'New Arrivals', 'url'=>array('#', 'tag'=>'new')),
                array('label'=>'Most Popular','active'=>1, 'url'=>array('#', 'tag'=>'popular'))
                )
            );
     */
    public $dropdown_items = array();
    public $dropdown_select = '';
    public $dropdown_name = 'sl-drop';
    public $list_items = array();
    public $list_items_additional=array();

    protected function renderContent()
    {
        echo CHtml::dropDownList($this->dropdown_name, $this->dropdown_select, $this->dropdown_items, array('class'=>'sl-drop'));
        
        if (!empty($this->list_items))
        {
            $this->widget('zii.widgets.CMenu', array(
                'items'=>$this->list_items,
                'id'=>'left-menu',
                'htmlOptions'=>array('class'=>'sl-menu')
            ));
        }
        
        if (!empty($this->list_items_additional))
        {
            $this->widget('application.widgets.MenuCheckbox', array(
                'items'=>$this->list_items_additional,
                'htmlOptions'=>array('class'=>'sl-menu')
            ));
        }

        $cs = Yii::app()->getClientScript();
        $cs->registerScript(__CLASS__, '$(document).ready(function(){

                                       $("#'.$this->dropdown_name.' option").click(function(){
                                              window.location.href = this.value;
                                           });

                                       $("#'.$this->dropdown_name.'").keyup(function(e)
                                       {
                                           if (e.keyCode==13)
                                           {
                                               $(this).find("option:selected").trigger("click");
                                           }
                                       });

                                       });');


    }

}