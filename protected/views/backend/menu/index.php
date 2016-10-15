<div class="list list-menu">
    <?php
    foreach($menu as $item)
    {
    ?>
        <div class="item <?php echo ($item->status==$item::STATUS_OK ? 'active' : '') ?>" onclick="location='<?php echo $this->createUrl('update').'?menu_id='.$item->id; ?>'">
                <div class="pull-left">
                    <img src="/images/icon-admin/menu-folder.png">
                    <?php echo Chtml::link($item->title,array('update','menu_id'=>$item->id)); ?>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->createUrl('delete_menu',array('id'=>$item->id)); ?>" class="btn btn-small btn-trash"><span class="fa fa-trash-o"></span></a>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->createUrl('active_menu',array('id'=>$item->id)); ?>" class="btn btn-small btn-active"><span class="icon-admin-power-switch-<?php echo ($item->status==$item::STATUS_OK ? 'green' : 'red') ?>"></span></a>
                </div>
        </div>
    <?php
    }
    ?>
</div>