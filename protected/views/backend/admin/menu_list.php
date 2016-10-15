<div class="menu-list">
<?php
    foreach($menu as $item)
    {
        echo
            '<a class="col-xs-6 menu-item" href="'.$item['url'].'">
                <div class="col-xs-2"><img src="/'.$item['image'].'" /></div>
                <div class="col-xs-10">'.$item['title'].'</div>
            </a>';
    }
?>
</div>