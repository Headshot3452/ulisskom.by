<?php
    foreach($this->_items as $item)
    {
        echo
            '<div class="item">
                <div class="date">'.date($this->dateFormat,$item->time).'</div>
                <div class="title">'.CHtml::link($item->title,array('news/item','name'=>$item->name)).'</div>
            </div>';
    }