<?php
class AlertWidget extends CWidget
{
    public $componentId='user';
    //типы алертов
    protected $_alerts=array(
                            array('type'=>'modal','render'=>'renderModal'), //модальные окна
                        );

    public $htmlOptions = array();

    public function init()
    {
        if (!isset($this->htmlOptions['id']))
            $this->htmlOptions=$this->getId();
    }

    public function run()
    {
        foreach ($this->alerts as $alert)
        {
            if (Yii::app()->{$this->componentId}->hasFlash($alert['type']))
            {
                $this->$alert['render'](Yii::app()->{$this->componentId}->getFlash($alert['type']));
            }
        }
    }

    public function renderModal($message)
    {
        $settings = array('url'=>'#',
                       'header'=>'',
                       'content'=>'',
                       'button_label'=>'Ok');
        if (is_array($message))
        {
            $settings = CMap::mergeArray($settings, $message);
        }
        else
            $settings['content']=$message;

        Yii::app()->getClientScript()->registerScript('renderModal'.$this->id,' $("#'.$this->id.'").modal("show");');

        echo '<div class="modal" id="'.$this->id.'">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">'.$settings['header'].'</h4>
                  </div>
                  <div class="modal-body">
                    '.$settings['content'].'
                  </div>
                  <div class="modal-footer">
                    '.BsHtml::button($settings['button_label'], array('data-dismiss' => 'modal', 'color' => BsHtml::BUTTON_COLOR_PRIMARY)).'
                  </div>
                </div>
              </div>
            </div>';
    }

    public function getAlerts()
    {
        return $this->_alerts;
    }
}
?>
