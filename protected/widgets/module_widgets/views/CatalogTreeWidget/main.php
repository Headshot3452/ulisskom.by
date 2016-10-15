<?php
    foreach($this->_items as $item) {
        if(empty($item['children'])) {
            continue;
        }
        foreach($item['children'] as $children) {
            if (($files = unserialize($children['images']))) {
                $image = $files[0]["path"].'big/'.$files[0]["name"];
            } else {
                $image = Yii::app()->params['no-image'];
            }
            $child_item = '';
            if($children['children']) {
                foreach($children['children'] as $child) {
                    $child_item .= '
                        <li><a href="#">'.$child['title'].'<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                    ';
                }
            }
            echo '
            <div class="row container-main-catalog-part">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-4 sm-pd-right-no">
                            <h3>'.$children['title'].'</h3>
                            <ul class="catalog-list">
                                '.$child_item.'
                            </ul>
                        </div>
                        <div class="col-xs-8 sm-pd-left-no">
                            <a href="">
                                <img class="container-main-catalog-image" src="/'.$image.'">
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }