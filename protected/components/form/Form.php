<?php
class Form extends CForm
{
	public $inputElementClass='FormInputElement';

	private $_labelOptions = array();

    public $stateful=false;

    private $_key;

    public function __construct($config, $model = null, $parent = null, $key=null)
    {
        $this->_key=$key;
		if(isset($config['labelOptions']))
		{
			$this->_labelOptions = $config['labelOptions'];
			unset($config['labelOptions']);
		}
        parent::__construct($config, $model, $parent);
    }


    public function renderBegin()
    {
            $output=parent::renderBegin();
            if ($this->stateful)
            {
                $output.=CHtml::tag('div',array('style'=>'display:none'),CHtml::pageStateField(''));
            }
           return $output;
    }
    
    public function renderView()
	{
		$output='';
		if($this->title!==null)
		{
			if($this->getParent() instanceof self)
			{
				$attributes=$this->attributes;
				unset($attributes['name'],$attributes['type']);
				$output=CHtml::openTag('fieldset', $attributes)."<legend>".$this->title."</legend>\n";
			}
			else
				$output="<fieldset>\n<legend>".$this->title."</legend>\n";
		}

		if($this->description!==null)
			$output.="<div class=\"description\">\n".$this->description."</div>\n";

		$output.=$this->renderViewElements()."\n";

		if($this->title!==null)
			$output.="</fieldset>\n";

		return $output;
	}  
    
    public function renderViewElements()
	{
		$output='';
		foreach($this->getElements() as $element)
			$output.=$this->renderViewElement($element);
		return $output;
	}
    
    public function renderViewElement($element)
	{
		if(is_string($element))
		{
			if(($e=$this[$element])===null && ($e=$this->getButtons()->itemAt($element))===null)
				return $element;
			else
				$element=$e;
		}
		if($element->getVisible())
		{
			if($element instanceof CFormInputElement)
			{
				if($element->type==='hidden')
					return "";
				else
					return "<div class=\"row field_{$element->name}\">\n".$element->renderView()."</div>\n";
			}
			elseif($element instanceof CFormButtonElement)
				return $element->render()."\n";
			elseif($element instanceof CFormStringElement)
				return $element->render();
            else 
                return $element->renderView();
		}
		return '';
	}

    public function loadData()
    {

	if($this->model!==null)
	{
	    $class=get_class($this->model);
	    if(strcasecmp($this->getRoot()->method,'get'))
	    {
		if(isset($_POST[$class]))
		{
		    if ($this->isTabular() && isset($_POST[$class][$this->_key]))
			$this->model->setAttributes($_POST[$class][$this->_key]);
		     else
			$this->model->setAttributes($_POST[$class]);
		}
	    }
	    elseif(isset($_GET[$class]))
	    {
		if ($this->isTabular() && isset($_GET[$class][$this->_key]))
		    $this->model->setAttributes($_GET[$class][$this->_key]);
		else
		    $this->model->setAttributes($_GET[$class]);
	    }
	}

	foreach($this->getElements() as $element)
	{
		if($element instanceof self)
			$element->loadData();
	}
    }


    public function isTabular()
    {
	return isset($this->_key);
    }


    public function renderElement($element)
    {
	    if(is_string($element))
	    {
		    if(($e=$this[$element])===null && ($e=$this->getButtons()->itemAt($element))===null)
			    return $element;
		    else
			    $element=$e;
	    }
	    if($element->getVisible())
	    {
		    if($element instanceof CFormInputElement)
		    {
			    if($element->type==='hidden')
				    return "<div style=\"visibility:hidden\">\n".$element->render()."</div>\n";
			    else
			    {
				$elementName=$element->name;
				return "<div class=\"form-group field_". strtolower(preg_replace('/(\[\w*\])?\[(\w*)\]/', '_$2', CHtml::resolveName($element->getParent()->getModel(), $elementName)))."\">\n".$element->render()."</div>\n";
			    }
		    }
		    elseif($element instanceof CFormButtonElement)
			    return $element->render()."\n";
		    else
			    return $element->render();
	    }
	    return '';
    }

    public function submitted($buttonName='submit',$loadData=true)
    {
	    if (Yii::app()->request->isAjaxRequest)
	    {
		$ret=$this->clicked($this->getUniqueId());
		if($ret && $loadData)
		    $this->loadData();
		return $ret;
	    }
	    else
	    {
		    return parent::submitted($buttonName,$loadData);
	    }
	    return false;
    }
}
?>
