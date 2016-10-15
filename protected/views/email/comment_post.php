<table class="table">
    <tbody>
    <tr>
        <td style="border:solid 1px #999999;padding: 4px 6px 4px 6px;"><div class="input-xlarge"></div>Ваш пост <?php echo $post->title; ?> прокомментировали.</td>
    </tr>
    <tr>
        <td style="text-align:right;width:110px;border:solid 1px #999999;padding: 4px 6px 4px 6px;">Текст комментария</td>
        <td style="border:solid 1px #999999;padding: 4px 6px 4px 6px;"><div class="input-xlarge"><?php echo $model->text; ?></div></td>
    </tr>
    </tbody>
</table>