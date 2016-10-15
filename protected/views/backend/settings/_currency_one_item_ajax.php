<div class="row one_item">
    <div class="col-xs-2">
        <div class="status active">
            <?php echo BsHtml::dropDownList('currency[]','currency', SettingsCurrencyList::getListCurrencyNotBasic(), array('empty' => '-', 'options' => array('-' => array('selected' => true)))); ?>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="icon">
            <span class=">"></span>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="cource">
            <div class="one">1</div>
            <?php echo BsHtml::label('=', 'one'); ?>
            <?php echo BsHtml::textField('SettingsCurrency[course][]', '', array('class'=> 'course')); ?>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="kind">
            <?php echo number_format(99999,0,'.', ' '); ?>
        </div>
    </div>
</div>