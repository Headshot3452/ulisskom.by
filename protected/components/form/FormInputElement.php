<?php
class FormInputElement extends CFormInputElement{

	public function render($labelOptions=array())
	{
		if($this->type==='hidden')
			return $this->renderInput();
		$output=array(
			'{label}'=>$this->renderLabel($labelOptions),
			'{input}'=>$this->renderInput(),
			'{hint}'=>$this->renderHint(),
			'{error}'=>$this->getParent()->showErrorSummary ? '' : $this->renderError(),
		);
		return strtr($this->layout,$output);
	}

    public function renderView($labelOptions=array())
	{
		if($this->type==='hidden')
			return $this->renderInput();
		$output=array(
			'{label}'=>$this->renderViewLabel($labelOptions),
			'{input}'=>$this->renderViewInput(),
			'{hint}'=>'',
			'{error}'=>'',
		);
		return strtr($this->layout,$output);
	}

	public function renderLabel($options=array())
	{
		$options = CMap::mergeArray($options, array(
			'label'=>$this->getLabel(),
			'required'=>$this->getRequired()
		));

		if(!empty($this->attributes['id']))
        {
            $options['for'] = $this->attributes['id'];
        }

		return CHtml::activeLabel($this->getParent()->getModel(), $this->name, $options);
	}

    public function renderViewLabel($options=array())
	{
		if(!empty($this->attributes['id']))
        {
            $options['for'] = $this->attributes['id'];
        }
        return CHtml::tag('div',$options,$this->getParent()->getModel()->getAttributeLabel($this->getLabel()));
	}

	public function getLabel()
	{
		if( preg_match('/(\[\w+\])(\w+)/', $this->name))
		{
			return $this->getParent()->getModel()->getAttributeLabel(preg_replace('/(\[\w+\])?(\w+)/', '$2', $this->name));
		}

		return parent::getLabel();
	}

    public function renderViewInput()
	{
		if(isset(self::$coreTypes[$this->type]))
		{
            $value='';
            $htmlOptions=array('class'=>$this->type);
			$method=self::$coreTypes[$this->type];
			if(strpos($method,'List')!==false)
            {
                CHtml::resolveNameID($this->getParent()->getModel(),$this->name,$this->attributes);
                $selection=Chtml::resolveValue($this->getParent()->getModel(),$this->name);
                foreach ($this->items as $key=>$item)
                {
                    if ($selection==$key)
                    {
                        $value.=$item.' ';
                    }
                }
            }
			else
            {
                $value=CHtml::resolveValue($this->getParent()->getModel(),$this->name);
                $htmlOptions=CMap::mergeArray($htmlOptions, $this->attributes);
            }
			return CHtml::tag('div',$htmlOptions,$value);
		}
		else
		{
			$attributes=$this->attributes;
			$attributes['model']=$this->getParent()->getModel();
			$attributes['attribute']=$this->name;
			ob_start();
			$this->getParent()->getOwner()->widget($this->type, $attributes);
			return ob_get_clean();
		}
	}
}
