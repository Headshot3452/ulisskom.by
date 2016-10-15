
<?include 'modal.php';?>

<script>
    $(document).ready(function() {

        $(".catalog-prds-img a").fancybox({
            padding:0
        });

        $("#special_offer3").owlCarousel({
            navigation : false,
            slideSpeed : 300,
            pagination : false,
            items :  4 ,
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
        });

        $("#special_offer_catalog").owlCarousel({
            navigation : false,
            slideSpeed : 300,
            pagination : false,
            items :  4 ,
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
        });

        $(".special_offer_prev").click( function() {
            $(this).parents('.special_offer_wrap').find('.special_offer').data('owlCarousel').prev();
        });
        $(".special_offer_next").click( function() {
            $(this).parents('.special_offer_wrap').find('.special_offer').data('owlCarousel').next();
        });
        $(window).resize(function () {
            console.log($(window).width());
            if($(window).width() < 1200){
                $("#scroller").css('right','20px');
            } else {
                $("#scroller").css('right',($(window).width()-1230)/2+'px');
            }
        });
        if($(window).width() < 1200){
            $("#scroller").css('right','20px');
        } else {
            $("#scroller").css('right',($(window).width()-1230)/2+'px');
        }

        $(window).scroll(function () {
            if ($(this).scrollTop() > 0) {
                $('#scroller').fadeIn();
            } else {
                $('#scroller').fadeOut();
            }
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 252) {
                $('.hdr-third.hdr-fixed').removeClass('hidden');
            } else {
                $('.hdr-third.hdr-fixed').addClass('hidden');
            }
        });

        $('#scroller').click(function () {
            $('body,html').animate({scrollTop: 0}, 400);
            return false;
        });
    });
</script>
<script src="/js/classie.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script>
    (function() {
        // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
        if (!String.prototype.trim) {
            (function() {
                // Make sure we trim BOM and NBSP
                var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                String.prototype.trim = function() {
                    return this.replace(rtrim, '');
                };
            })();
        }

        [].slice.call( document.querySelectorAll( 'input.input__field,textarea.input__field' ) ).forEach( function( inputEl ) {
            // in case the input is already filled..
            if( inputEl.value.trim() !== '' ) {
                classie.add( inputEl.parentNode, 'input--filled' );
            }

            // events:
            inputEl.addEventListener( 'focus', onInputFocus );
            inputEl.addEventListener( 'blur', onInputBlur );
        } );

        function onInputFocus( ev ) {
            classie.add( ev.target.parentNode, 'input--filled' );
        }

        function onInputBlur( ev ) {
            if( ev.target.value.trim() === '' ) {
                classie.remove( ev.target.parentNode, 'input--filled' );
            }
        }
    })();
</script>
<script>
    $('.dropdown-juro .dropdown-menu > li > a ').click(function () {
        $(this).parents('.dropdown-juro').find('button').html($(this).text()+'<i class="fa fa-angle-down pull-right" aria-hidden="true"></i>');
        $(this).parents('.dropdown-juro').find('input').val($(this).text());
        return false;
    })
</script>
    <div id="scroller">
        <span class="fa fa-angle-up fa-3x"></span>
    </div>

    <footer>
        <div class="ftr-top tp-mrg70">
            <div class="ftr-top-right-bg"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-2">
                        <a href="/"><img src="/images/logo-bottom.png"></a>
                    </div>
                    <div class="col-xs-2">
                        <h4>Входные двери</h4>
                        <ul class="footer-catalog">
                            <li><a href="#">Стальная линия</a></li>
                            <li><a href="#">Форпост</a></li>
                            <li><a href="#">Континент</a></li>
                        </ul>

                    </div>
                    <div class="col-xs-2">
                        <h4>Фурнитура</h4>
                        <ul class="footer-catalog">
                            <li><a href="#">Замки</a></li>
                            <li><a href="#">Ручки</a></li>
                            <li><a href="#">Доводчики</a></li>
                            <li><a href="#">Уплотнитель</a></li>
                            <li><a href="#">Фурнитура для дверей</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-3">
                        <h4>Межкомнатные двери</h4>
                        <ul class="footer-catalog">
                            <li><a href="#">Производитель</a></li>
                            <li><a href="#">Новый производитель</a></li>
                            <li><a href="#">Еще один производитель</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-3 ftp-contacts">
                        <p>Закажите дверь</p>
                        <div>
                            <span class="hdr-phone__pre-number"><?php echo $this->phones[0]['code'] ;?></span>
                            <span class="hdr-phone__number"><?php echo $this->phones[0]['number'] ;?></span>
                        </div>
                        <p>Или узнайте про фурнитуру</p>
                        <div>
                            <span class="hdr-phone__pre-number"><?php echo $this->phones[1]['code'] ;?></span>
                            <span class="hdr-phone__number"><?php echo $this->phones[1]['number'] ;?></span>
                        </div>
                        <a href="#" class="more-contacts">Больше контактов</a>
                        <div class="socials">
                            <a href="#"><span class="fa fa-vk"></span></a>
                            <a href="#"><span class="fa fa-facebook"></span></a>
                            <a href="#"><span class="fa fa-odnoklassniki"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ftp-bt">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">© ЧТУП "УлиссКом", <?php echo date('Y') ;?> Все права защищены</div>
                    <div class="col-xs-6 text-right">
                        Создание сайта - <a class="red-link" href="https://www.kinopoisk.ru/film/9691/">Славные парни</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

<?php
    $cs = Yii::app()->getClientScript();
    $scrollTo = '
        $(window).scroll(function()
        {
            if($(this).scrollTop() != 0) {
                $("#toTop").fadeIn();
            } else {
                $("#toTop").fadeOut();
            }
        });
        $("#toTop").click(function() {
            $("body, html").animate({scrollTop:0}, 800);
        });
    ';
    $cs->registerScript('scrollTo', $scrollTo);