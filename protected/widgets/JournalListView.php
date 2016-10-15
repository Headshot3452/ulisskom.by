<?php
Yii::import('zii.widgets.CListView');

class JournalListView extends CListView
{
    protected $_configTemplate=array(
                    '0'=>'Пользователь {1}, пользователь {2}',
                );
    
    protected $_journalContent;


    public function getJournalContent($data)
    {
        if (isset($data->type) and isset($data->content))
        {
            if (isset($this->_configTemplate[$data->type]))
            {
                $this->_journalContent=@unserialize($data->content);
                ob_start();
                echo preg_replace_callback('/{(\w+)}/', array($this,'renderJournalContent'), $this->_configTemplate[$data->type]);
                ob_end_flush();
            }
        }
        else
           throw new CException('Not data params');
    }
    
    public function renderJournalContent($matches)
    {
        $method='renderJournal'.$matches[1];
        if (isset($this->_journalContent[$matches[1]]))
        {
            return $this->_journalContent[$matches[1]];
        }
        elseif(method_exists($this,$method))
        {
            $this->$method();
            $html=ob_get_contents();
            ob_clean();
            return $html;
        }
        return $matches[0];
    }    
}
?>
