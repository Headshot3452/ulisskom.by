<?php
Yii::import('zii.widgets.CMenu');
class LeftMenuWidget extends CMenu
{
    public $descriptionTag='span';
    public $descriptionHtmlOptions=array(
                                        'class'=>'description'
                                        );
    
    protected function renderMenuItem($item)
	{
        $output=parent::renderMenuItem($item);
        
        if(!empty($item['description']))
        {
            $output.=CHtml::tag($this->descriptionTag,$this->descriptionHtmlOptions, $item['description']);
        }
        return $output;
	}
}
?>
