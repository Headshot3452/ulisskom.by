<div class="article-page">
    <?php
    $image = $article->getOneFile('big');
    $img = '';
    if($image)
    {
        echo '<img src="/'.$image.'" class="thumbnail">';
    }

    echo $this->text;
    ?>
</div>