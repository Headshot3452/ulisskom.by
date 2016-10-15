<?php

echo
    '<div class="ask">
        <div class="title">'.
    CHtml::link("<h4>".$data->title."</h4>",$this->createUrl('askanswer/index').$data->name).
    '</div>
        <div class="answer">'.$data->text.'</div>
        </div>';