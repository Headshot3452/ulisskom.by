<div class="dropdown status-feedback status-blog">
  	<button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
  		<?php echo !empty($_GET['status'])?Tags::getStatusTagsSort($_GET['status']):'Все'; ?>
        <span class="caret"></span>
    </button>
  	<ul class="dropdown-menu" role="menu">
    	<li><a id="1">Последние Русские</a></li>
    	<li><a id="2">Последние English</a></li>
    	<li><a id="3">От А до Я</a></li>
    	<li><a id="4">От A до Z</a></li>
  	</ul>
</div>

<?php
$status_blog="
    $('.status-feedback ul a').on('click', function(){
        var value = $(this).attr('id');

        $('.status-feedback button').html($(this).html()+'<span class=\"caret\"></span>');
        $('.filter-blog .status-value').val(value);
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('$status_blog',$status_blog);

?>