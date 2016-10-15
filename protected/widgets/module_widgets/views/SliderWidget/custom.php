<div class="container-fluid container-relative">
    <div class="row">
        <span class="owl-carousel-np-controls owl-carousel-np-controls-before"></span>
        <span class="owl-carousel-np-controls owl-carousel-np-controls-after"></span>
        <div id="mainSlider" class="owl-carousel owl-theme">
<?php
            foreach($this->_items as $item) {
                $image = $item->getOneFile('origin');
                echo '<div class="item"><img src="'.$image.'"></div>';
            }
?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#mainSlider").owlCarousel({
            navigation: false,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true
        });
        $(".owl-carousel-np-controls-after").click( function() {
            $("#mainSlider").data('owlCarousel').next();
        });
        $(".owl-carousel-np-controls-before").click( function() {
            $("#mainSlider").data('owlCarousel').prev();
        });
    });
</script>