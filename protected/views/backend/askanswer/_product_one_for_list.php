<li class="one_item" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-2">
            <div class="status <?php echo ($data->status == 1) ? 'active' : 'not_active'; ?>">
                <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
                <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
                <div class="identity"><?php echo $data->id; ?></div>
                <div class="date text-center">
                    <?php echo date("d.m.Y H:m", $data->time); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-8 name">
<?php
            echo BsHtml::link($this->SubStr($data->title, 300),$this->createUrl('update').'?id='.$data->id);

            if(!empty($data->article))
            {
?>
                <div class="article">
                    <span>Арт.</span><?php echo $data->article; ?>
                </div>
<?php
            }
?>
        </div>
        <div class="col-xs-2 text-right">
            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
            <img class="answer_ok" src="/images/<?php echo (!empty($data->answer_ok)) ? 'answer_ok' : 'answer_not_ok' ; ?>.png" alt="Наличие ответа" title="Наличие ответа"/>
        </div>
    </div>
</li>