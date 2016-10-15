<?php
/* @var $this BannersController */
/* @var $model Banners */
?>
<?php
$this->renderPartial('_form',array('model'=>$model));
if (Yii::app()->user->hasFlash('success'))
	{
		echo '<div class="alert alert-success">
			 <button type="button" class="close" data-dismiss="alert">&times;</button>
			 '.Yii::app()->user->getFlash('success').'</div>';
	}
?>
