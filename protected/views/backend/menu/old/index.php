<div class="list">
    <?php
    foreach($menu as $item)
    {
    ?>
        <div class="item <?php echo ($item->status==$item::STATUS_OK ? 'active' : '') ?>">
                <div class="pull-left"><?php echo Chtml::link($item->title,array('update','id'=>$item->id)); ?></div>
                <div class="pull-right"><a href="<?php echo $this->createUrl('active',array('id'=>$item->id)); ?>" class="btn btn-small btn-active"><span class="icon-admin-power-switch-<?php echo ($item->status==$item::STATUS_OK ? 'green' : 'red') ?>"></span></a></div>
                <div class="clearfix"></div>
        </div>
    <?php
    }
    ?>
</div>