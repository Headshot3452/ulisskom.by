<div class="main-title-block main-title">
    <div class="container">
        <a class="menu-back" href="<?php echo $this->createUrl('admin/index'); ?>"><span class="fa fa-angle-left"></span></a>
        <span class="title"><?php echo $this->getTopMenuTitle(); ?></span>

        <span class="dropdown">
            <a href="javascript:void(0)" data-toggle="dropdown" data-target="#" role="button" class="btn btn-default"><i class="caret"></i></a>
                <?php
                    $this->widget('bootstrap.widgets.BsNav',array(
                            'htmlOptions'=>array(
                                'class'=>'dropdown-menu',
                                'role'=>'menu'
                            ),
                            'items'=>$this->getTopMenuItemsWithActive(),
                        )
                    );
                ?>
        </span>
        <?php try{ ?>
        <nav class="top-menu-select navbar navbar-default" role="navigation">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                   'items'=>$this->getTopMenu(),
                    'htmlOptions' => array('class' => 'nav navbar-nav'),
                ));
            ?>
        </nav>
        <?php }catch(Exception $e){} ?>
    </div>
</div>

<div class="main-title-block module-title">
    <div class="container">
        <?php echo $this->pageTitleBlock; ?>
    </div>
</div>

<div class="container">
<?php
    $this->widget('zii.widgets.CBreadcrumbs',
        array(
            'homeLink' => CHtml::link(Yii::t('app', 'Home'), Yii::app()->createUrl('admin')),
            'separator' => ' / ',
            'links' => $this->getBreadcrumbs(),
        )
    );
?>
</div>