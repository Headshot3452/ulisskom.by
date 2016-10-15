<?php

class ModalTree extends CInputWidget
{

    public $modalTitle = 'Title';//заголовок модального окна

    public $closeLabel = 'Отмена';//Лейбл кнопки закрытия

    public $saveLabel = 'Сохранить';//Лейбл кнопки сохранения

    public $modalOptions = array('id'=>'modalTree');//параметры для модального окна

    public $openLinkTitle = 'Выбрать';//заголовок ссылки, вызывающей откртытие окна

    public $treeOptions = array();//параметры для CTreeView

    public $idTargetBlock = 'modalTarget';//ид блока куда вставляются выбранные рзультаты

    public $checkFullBranch = false; //галка которая отмечает все пункты в ветке


    public function run()
	{
        $id = isset($this->modalOptions['id']) ? $this->modalOptions['id'] : 'modalTree';

        echo '<div class="modal-items-block" id="'.$this->idTargetBlock.'"></div>';
        echo CHtml::tag('div',array('class'=>'modal-select','data-toggle' => 'modal','data-target' => '#'.$id),$this->openLinkTitle);

        $this->beginWidget('bootstrap.widgets.TbModal', $this->modalOptions);

        echo '<div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h4>'.$this->modalTitle.'</h4>
            </div>';

        echo  '<div class="modal-body">';
        if($this->treeOptions)
        {
            if($this->checkFullBranch)
            {
                foreach($this->treeOptions['data'] as &$item)
                {
                    $item['text'] = CHtml::checkBox('',false,array('class'=>'check-all')).$item['text'];
                }
            }
            $this->widget('CTreeView', $this->treeOptions);
        }
        echo '</div>';

        echo '<div class="modal-footer">';

        $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'primary',
            'label'=>$this->saveLabel,
            'url'=>'javascript:insertCheckedAreas()',
        ));

        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>$this->closeLabel,
            'url'=>'javascript:uncheck()',

        ));

        echo '</div>';

         $this->endWidget();

         $cs = Yii::app()->getClientScript();

         $cs->registerScript(__CLASS__.'#'.$id, " $(document).ready(function(){
                    check();

                    $('body').on('click','.insert-branch .close',function(){
                        var item_id = $(this).attr('item');
                        $('#".$id."').find('input:checked[value='+item_id+']').removeAttr('checked');
                        $(this).parent().remove();
                    });

                    $('#".$id." .check-all').change(function(){
                        if(this.checked)
                        {
                            $(this).parent().find('li input').attr('checked','checked');
                        }
                        else
                        {
                            $(this).parent().find('li input').removeAttr('checked');
                        }
                    });

                });

                $(window).load(function(){
                    $('#".$id."').find('li.expandable').each(function(i){
                        if($(this).find('input:checked').length>0)
                            $(this).find('>div.hitarea').click();
                    });

                });

                function uncheck()
                {
                    $('#".$id."').find('input:checked').removeAttr('checked');
                    $('#".$this->idTargetBlock." .insert-branch .close').each(function(i){
                             var item_id = $(this).attr('item');
                            $('#".$id."').find('input[value='+item_id+']').attr('checked','checked');
                    });
                    $('#".$id."').modal('hide');
                }

                function check()
                {
                    $('#".$id."').find('input:checked').each(function(i){
                        var block = '<div class=\'insert-branch\'><span>- '+$(this).next('label').html()+'</span> <span class=\'close\' item='+$(this).val()+'><i class=\'icon-remove\'></i></span></div>';
                        $('#".$this->idTargetBlock."').append(block);
                    });
                }

                function insertCheckedAreas()
                {
                    $('#".$this->idTargetBlock."').html('');
                    check();
                    $('#".$id."').modal('hide');
                }",CClientScript::POS_END);
    }

}

