<div class="row one-draft media">
    <a class="pull-left" href="<?php echo $this->createUrl('profileblog/createpost', array('id'=>$data->id)); ?>">
        <?php
            $images = $data->getOneFile();

            if(!empty($images))
            {
                echo CHtml::image($images, $data->title);
            }
            else
            {
                echo CHtml::image('/'.Yii::app()->params['noimage'], $data->title);
            }
        ?>
    </a>
    <div class="media-body">
        <div class="col-md-11">
                <div class="text" onclick="location.href='<?php echo $this->createUrl('profileblog/createpost', array('id'=>$data->id)); ?>'">
                    <?php echo $this->Substr($data->text, 450); ?>
                </div>
                <div class="breadcr">
                    <span class="fa fa-folder-open"></span>
                    <?php echo BlogTree::CreatePathForItemLink($data->id); ?>
                </div>
            </div>
    </div>
</div>