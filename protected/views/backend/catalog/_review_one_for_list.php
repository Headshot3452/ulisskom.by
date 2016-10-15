<?php
    if (!empty($data))
    {
        $link = $this->createUrl('',array('id' => $data->id));

        $status = '';
        switch ($data->status)
        {
            case 1:
                $status = 'status-new';
                break;
            case 2:
                $status = 'status-moderate';
                break;
            case 5:
            case 6:
                $status = 'status-placement';
                break;
            case 7:
                $status = 'status-rejected';
                break;
        }
    }
?>

<li class="one_item" id="<?php echo $data->id;?>">
    <div class="row">
        <div class="col-xs-2">
            <div class="status <?php echo $status ;?>">
                <?php echo BsHtml::checkBox('checkbox['.$data->id.']',false,array('class'=>'checkbox group')); ?>
                <?php echo BsHtml::label('','checkbox_'.$data->id,false,array('class'=>'checkbox')); ?>
                <div class="identity"><?php echo $data->id; ?></div>
                <div class="date text-center">
                    <?php echo date("d.m.Y H:m", $data->create_time); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-8 name" role="button" data-toggle="modal">
            <?php echo $data->header ;?>
        </div>
        <div class="col-xs-2 text-right">
            <img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/>
            <img class="answer_ok" src="/images/<?php echo (!empty($data->note)) ? 'answer_ok' : 'answer_not_ok' ; ?>.png" alt="Наличие ответа" title="Наличие ответа"/>
        </div>
    </div>
</li>