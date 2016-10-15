<?php
    echo Yii::t('app','To complete the recover password').', '. CHtml::link(Yii::t('app','click here'),Yii::app()->createAbsoluteUrl($action,array('hash'=>$model->hash)));
?>.