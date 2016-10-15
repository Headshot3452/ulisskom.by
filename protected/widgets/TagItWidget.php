<?php
class TagItWidget extends Portlet
{
    public $items=array();

    public $autoCompliteSoutce=array('tags/search');

    public function renderContent()
    {
        $cs=Yii::app()->getClientScript();
        $cs->registerPackage('tagit');


        $options=array(
            'fieldName'=>'tags[]',
            'autocomplete'=>array(
                'delay'=>0,
                'minLength'=>0,
                'source'=>CHtml::normalizeUrl($this->autoCompliteSoutce),
            )
        );

        $tagit='
            $("#'.$this->id.'").tagit('.CJavaScript::encode($options).');
        ';
        $cs->registerScript('tagit',$tagit);

        echo '<ul id="'.$this->id.'">';
                foreach($this->items as $item)
                {
                    echo '<li>'.CHtml::encode($item).'</li>';
                }
        echo '</ul>';

    }
}