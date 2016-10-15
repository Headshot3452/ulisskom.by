<div class="dropdown status-feedback status-blog">
  	<button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
  		<?php echo Blog::getStatusForSearch(isset($_GET['status'])?$_GET['status']:'default'); ?>
        <span class="caret"></span>
    </button>
  	<ul class="dropdown-menu" role="menu">
    	<li><a id="1" style="color: blue;">Новые</a></li>
    	<li><a id="2" style="color: orange;">На модерации</a></li>
    	<li><a id="4" style="color: green;">Размещенные</a></li>
    	<li><a id="5" style="color: red;">Отклонненые</a></li>
  	</ul>
</div>

<?php
$status_blog="
    $('.status-feedback ul a').on('click', function(){
        var value = $(this).attr('id');

        $('.status-feedback button').html($(this).html()+'<span class=\"caret\" style=\"color: #000\"></span>');
        $('.filter-blog .status-value').val(value);

        var color;

        if(value==1)
            color = 'blue';
        if(value==2)
            color = 'orange';
        if(value==4)
            color = 'green';
        if(value==5)
            color = 'red';

        $('.status-feedback button').css('color',color);
    });

    $('.status-feedback ul a').hover(function(){
        $(this).css('color', '#fff');
    },
    function(){
        var value = $(this).attr('id');

        var color;

        if(value==1)
            color = 'blue';
        if(value==2)
            color = 'orange';
        if(value==4)
            color = 'green';
        if(value==5)
            color = 'red';

        $(this).css('color', color);
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('$status_blog',$status_blog);

?>