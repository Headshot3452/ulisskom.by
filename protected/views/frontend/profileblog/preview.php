<?php
$cs = Yii::app()->getClientScript();
$header_popovers = '
    $(".fa.fa-question-circle").popover()
    ';
$cs->registerScript("header_popovers", $header_popovers);
?>
<h2>Создание поста</h2><a href="/profileblog/add" class="pull-right btn btn-default">Выйти из предпросмотра</a>

<div class="row" id="add-post">
    <div class="col-md-12">
        <div class="border preview col-md-12 no-padding">
            <h2 class="col-md-12">Название статьи. Заголовок, отражающий суть написанного в
                посте.</h2>

            <div class="col-md-12 breadcr"><span class="fa fa-folder-open"></span> <a href="#">Honda</a> / <a href="#">Honda
                    CBR250RR</a> / <a href="#">Коробка передач</a>
            </div>
            <div class="col-md-12 text">
                <img src="/images/logo.png">
                Далеко-далеко за словесными
                горами в стране гласных и согласных живут рыбные тексты? Вдали от всех живут они в
                буквенных домах на берегу Семантика большого языкового океана. Маленький ручеек Даль
                журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта
                парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот.
                Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими
                безорфографичный образ жизни. Однажды одна маленькая строчка рыбного текста по имени
                Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о
                злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить
                Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими
                безорфографичный образ жизни. Однажды одна маленькая строчка рыбного текста по имени
                Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о
                злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить
                себя с толку.
            </div>
            <div class="labels col-md-12">
                <span class="fa fa-tag"></span>
                <a href="#">метка1</a>,
                <a href="#">метка</a>,
                <a href="#">простометка</a>,
                <a href="#">статья</a>,
                <a href="#">тег</a>
            </div>
        </div>
    </div>
    <div class="col-md-12 buttons">
        <div class="row">
            <div class="col-md-6 text-left">
                <button class="btn btn-primary" type="submit" name="">Опубликовать</button>
                <a class="" href="/profileblog/index">Отмена</a>
            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-default" href="/profileblog/draftsSave">Сохранить в черновики</a>
            </div>
        </div>
    </div>
</div>
