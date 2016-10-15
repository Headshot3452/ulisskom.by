<div class="dropdown status-feedback" style="border-color:<?php echo $model::getColorStatus($model->status); ?>">
  	<button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
  		<?php echo $model::getStatus($model->status); ?>
        <span class="caret"></span>
    </button>
  	<ul class="dropdown-menu" role="menu">
      <li><a id="1">Новый</a></li>
    	<li><a id="5">В обработке</a></li>
    	<li><a id="2">Ответили</a></li>
    	<li><a id="3">В архив</a></li>
    	<li><a id="4">Удалить</a></li>
  	</ul>
</div>