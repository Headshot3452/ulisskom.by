<?php
if($this->_banner)
{
    $image=$this->_banner->getOneFile($this->size);
    echo '<div class="banner-block">
                <div class="description-block pull-left">
                    <div class="title">
                    '.$this->_banner->title.'
                    </div>
                    <div class="description">
                     '.$this->_banner->description.'
                    </div>
                </div>
                <div class="arrow-block pull-left">
                </div>
                <div class="arrow pull-left">

                </div>
                <div class="image pull-left">
                        <img src="/'.$image.'">
                        <div class="hover">
                            <a href="'.$this->_banner->getOneFile('big').'" rel="lightbox"><span class="image-circle-search"></span></a>
                            <a href="'.$this->_banner->url.'"><span class="image-circle-link"></span></a>
                        </div>
                </div>
             </div>
        ';
}
