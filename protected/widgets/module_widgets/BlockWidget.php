<?php
class BlockWidget extends StructureWidget
{
    public $block_id;
    protected $_data;

    public function setData()
    {
        $this->_data=TextBlocks::findById($this->block_id,$this->controller->getCurrentLanguage()->id);

        if (!$this->_data)
            return false;

        return true;
    }

    public function renderContent()
    {
        echo $this->_data->text;
    }
}