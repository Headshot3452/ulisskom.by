<?php
    $this->pageTitleBlock = '<span class="pull-left title" style="margin-left: -37px;">Главная</span>';
?>

<div class="container main_page">
    <h3>Часто используемые модули</h3>
    <a href="<?php echo CHtml::normalizeUrl('settings/settingsLabel') ;?>">Настройки</a>
    <div class="clearfix"></div>
    <div class="modules">
<?php
        if(isset($item))
        {
            foreach ($item as $value)
            {
                $image = $value->files ? '/images/icon-admin/'.$value->files : Yii::app()->params['noimage'];
                echo
                    '<div class="main_page_cont">
                        <a href="/admin/'.CHtml::normalizeUrl($value->name).'"><img src="'.$image.'" alt=""/></a>
                        <span>'.$value->title.'</span>
                    </div>';
            }
        }
?>
    </div>
</div>
