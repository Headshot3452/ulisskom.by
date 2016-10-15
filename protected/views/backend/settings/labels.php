<?php
    $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('settings/index'));
    $this->pageTitleBlock .=
                    '<div class="img-cont">
                        <a href="'.$this->createUrl("settings/index").'">
                            <img src="/images/icon-admin/settings-label.png" alt="" title="">
                        </a>
                    </div>';
    $this->pageTitleBlock .= '<span class="pull-left title">Настройки ярлыков</span>';

    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'label-form',
            'enableAjaxValidation' => false,
        )
    );

    if(isset($item))
    {
        foreach($item as $value)
        {
            $disabled = $value->on_main ? '' : 'disabled';
            echo
                "<div class='no-left col-xs-7 settings-label ".$disabled."'>
                    ".$form->checkBox($value, '['.$value->id.']on_main', array('class' => 'checkbox group'))."
                    ".$form->label($value, '['.$value->id.']on_main', array('class' => 'checkbox', 'label' => ''))."
                    <img src='/images/icon-admin/".$value->files."' />
                    <span>$value->title</span>
                </div>";
        }
    }
?>
    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

<?php
    $this->endWidget();

    $cs = Yii::app()->getClientScript();

    $disabled =
        "$(function()
        {
            $('.checkbox.group').on('click', function(e)
            {
                if ($(this).closest('.settings-label').hasClass('disabled'))
                {
                    $(this).closest('.settings-label').removeClass('disabled');
                }
                else
                {
                    $(this).closest('.settings-label').addClass('disabled');
                }
            });
        });
    ;";

    $cs->registerScript('disabled', $disabled);

?>