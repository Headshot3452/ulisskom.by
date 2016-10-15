<div class="dropdown status-feedback status-blog">
  	<button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
  		Все
        <span class="caret"></span>
    </button>
  	<ul class="dropdown-menu" role="menu">
    	<li><a id="1">Хороший клиент</a></li>
    	<li><a id="2">Плохой клиент</a></li>
    	<li><a id="3">Злой клиент</a></li>
  	</ul>
</div>

<?php
$status_blog="
    $('.status-feedback ul a').on('click', function(){
        var value = $(this).attr('id');

        $('.status-feedback button').html($(this).html()+'<span class=\"caret\" style=\"color: #000\"></span>');
        $('.filter-blog .status-value').val(value);
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('$status_blog',$status_blog);

?>