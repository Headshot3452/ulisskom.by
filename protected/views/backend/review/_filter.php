<div class="form top-filter">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'review-filter',
            'method' => 'get',
            'enableAjaxValidation' => false,
            'action' => array('review/index'),
        )
    );
?>
    <div class="row">

        <div class="col-xs-3">
<?php
            $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('admin/siteManagement'));
            $this->pageTitleBlock .=
                                '<div class="img-cont" style="position: relative; z-index: 9999;">
                                    <a href="'.$this->createUrl("admin/siteManagement").'">
                                        <img src="/images/icon-admin/reviews.png" alt="" title="">
                                    </a>
                                </div>';
            $this->pageTitleBlock .= '<span class="pull-left title">'.Yii::t('app', 'Review').'</span>';
?>
        </div>

        <div class="col-xs-3">
            <div class="filter-title">
                Статус:
            </div>
            <?php echo BsHtml::dropDownList('status', 'status', $status == ReviewItem::STATUS_ARCHIVE ? array('3' => 'В архиве') : ReviewItem::getFilterStatus(), array('empty' => 'Все', 'options' => array(Yii::app()->request->getParam('status') => array('selected' => true)))); ?>
        </div>

        <div class="col-xs-3">
            <div class="filter-title">
                Период:
            </div>
            <div class="period">
<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'dd.mm.yy',
                        ),
                        'value' => Yii::app()->request->getParam('date_from'),
                        'htmlOptions' => array(
                            'class' => 'from form-control',
                            'name' => 'date_from'
                        ),
                    )
                );
?>
                &nbsp;-&nbsp;
<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'dd.mm.yy',
                        ),
                        'value' => Yii::app()->request->getParam('date_to'),
                        'htmlOptions' => array(
                            'class' => 'to form-control',
                            'name' => 'date_to'
                        ),
                    )
                );
?>
            </div>
        </div>

        <div class="col-xs-3 buttons">
<?php
                echo BsHtml::submitButton('',array('icon'=>BsHtml::GLYPHICON_SEARCH));
                echo '<a id="reset" class="btn btn-default"><span class="reset"></span></a>';
            $reset="
                $('#reset').on('click', function ()
            {
                $('#status').val(null);
                $('#date_from, #date_to').datepicker('setDate', null);
                $('#review-filter').submit();
            });
            $.datepicker.setDefaults(
            $.extend($.datepicker.regional['ru'])
            );
                ";
            $cs=Yii::app()->getClientScript();
            $cs->registerScriptFile('/js/jqueryui/datepicker-ru.js', CClientScript::POS_END);
            $cs->registerScript("reset",$reset);
?>
            <a href="<?php echo $this->createUrl('settings'); ?>" class="btn btn-default">
                <span class="icon-admin-settings"></span>
            </a>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>