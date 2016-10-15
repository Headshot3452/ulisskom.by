<div class="complaint">
    <?php foreach(Complaints::getComplaintsForPost($model->id, $this->module_id) as $key => $value): ?>
    <div class="complaint-area" style="right: <?php echo $key*21; ?>px;">
        <img src="/images/complaint.png" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?php echo $value['text']; ?>">
        <img src="/images/delete.png" class="remove-complaint" id="<?php echo $value['id']; ?>" alt="Удалить жалобу">
    </div>
    <?php endforeach; ?>
</div>

<div class="dropdown status-feedback status-blog-update" style="border-color:<?php echo $model::getColorStatus($model->status); ?>">
    <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
        <?php echo $model::getStatus($model->status); ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a id="1">Новый</a></li>
        <li><a id="2">На модерацию</a></li>
        <li><a id="4">Разместить</a></li>
        <li><a id="5">Оклонить</a></li>
    </ul>
</div>

<?php
$change="
        $('.btn-change').on('click', function(){
            if(!$('.post-text').find('.redactor-box').is(':visible'))
            {
                $('.post-text').find('.redactor-box').show();
                $('.post-text').find('.text-info').hide();
            }
            else
            {
                $('.post-text').find('.redactor-box').hide();
                $('.post-text').find('.text-info').show();
            }
        });

        $('.complaint img').popover();
        $('.complaint img').on('click', function(){
            $('.complaint img.active').popover('hide');

            if(!$(this).hasClass('active'))
                $(this).addClass('active');
            else
                $(this).removeClass('active');

            $('.complaint img.active').not(this).removeClass('active');
        });

        $('.complaint .complaint-area').hover(function(){
            $(this).find('.remove-complaint').fadeIn(100);
        },function(){
            $(this).find('.remove-complaint').fadeOut(100);
        });

        $('.complaint .remove-complaint').on('click', function(){
            var id = $(this).attr('id');
            $(this).parent().remove();

            $.ajax({
                type: 'POST',
                url : '".$this->createUrl('blog/index')."',
                data: {complaint_id:id},
                success: function(){
                    
                }
            });
        });
        ";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('$change',$change);

?>