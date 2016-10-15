<?php
class TypeacheadWidget extends CInputWidget
{
    public $js_file='typeahead.min.js';
    
    public $options = array();
    
    public function init()
    {
		$this->htmlOptions['type'] = 'text';
		$this->htmlOptions['data-provide'] = 'typeahead';
    }
    
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $id;

		if (isset($this->htmlOptions['name']))
			$name = $this->htmlOptions['name'];

		if ($this->hasModel())
			echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
		else
			echo CHtml::textField($name, $this->value, $this->htmlOptions);

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
        
        $cs=Yii::app()->clientScript;
        $cs->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.widgets.assets.js').'/hogan-2.0.0.js'),CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.widgets.assets.js').'/'.$this->js_file),CClientScript::POS_END);
		$cs->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').typeahead({$options})");
    }
}
?>
