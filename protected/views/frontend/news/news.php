<?php
$image = $news->getOneFile('big');
?>

<div class="container">

    <div class="one-news row">
        <div class="col-md-8">
            <h1><?php echo $news->title ?></h1>

            <div class="row">
                <div class="col-md-12 info">
                    <div class="pull-left">
                        <?php
                        echo CHtml::link('<span class="fa fa-long-arrow-left"></span> Назад к новостям', array('news/list'), array('class' => 'btn btn-default'));
                        ?>
                    </div>
                    <div class="date pull-right">
                        <?php echo Yii::app()->dateFormatter->format('d MMMM yyyy HH:mm', $news->time); ?>
                    </div>
                </div>
                <?php
                if(file_exists($image))
                    echo '<div class="image-news col-md-12 text-center">
                        <img src="/'.$image.'">
                    </div>';
                if($news->preview!='')
                    echo "<h3 class='anons col-md-12'> $news->preview</h3>";
                ?>
                <div class="col-md-12 text">
                    <?php
                    echo $news->text;
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 side-bar">
            <div class="col-md-12 widget">
                <div class="title row">
                    <div class="caption cat-categories">Виджет</div>
                </div>
                <div class="body">
                    <p>
                        Что-нибудь
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>