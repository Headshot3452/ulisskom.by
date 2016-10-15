<?php
    $lang = $this->getLanguages();
    $languages = array();
    foreach($lang as $val)
    {
        if($val->code == Yii::app()->language)
        {
            $label_lang = $val->title;
            continue;
        }
        $languages[] = array('label' => $val->title, 'url' => $this->createUrl('admin/language', array('code' => $val->code)));
    }

    $this->widget('bootstrap.widgets.BsNavbar',
        array(
            'brandLabel' => 'CMS',
            'brandUrl' => $this->createUrl('admin/index'),
            'collapse' => true, // requires bootstrap-responsive.css
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.BsNav',
                    'type' => 'navbar',
                    'items' => array(
                        array('label' => Yii::t('app', 'Pages'), 'url' => Yii::app()->createUrl('structure/index'), 'active' => (strpos(Yii::app()->request->requestUri, '/admin/structure/') !== false ? true : false)),
                        array('label' => Yii::t('app', 'Menu'), 'url' => Yii::app()->createUrl('menu/index'), 'active' => (strpos(Yii::app()->request->requestUri, '/admin/menu/') !== false ? true : false)),
                        array('label' => Yii::t('app', 'Catalog'), 'url' => Yii::app()->createUrl('catalog/index'), 'active' => (strpos(Yii::app()->request->requestUri, '/admin/catalog/') !== false ? true : false)),
                        array('label'=>Yii::t('app','News'), 'url'=>Yii::app()->createUrl('news/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/news/')!==false?true:false)),
                        array('label'=>Yii::t('app','Slider'), 'url'=>Yii::app()->createUrl('slider/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/slider/')!==false?true:false)),
                        array('label'=>Yii::t('app','Blocks'), 'url'=>Yii::app()->createUrl('blocks/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/blocks/')!==false?true:false)),
                        array('label'=>Yii::t('app','Banners'), 'url'=>Yii::app()->createUrl('promotions/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/promotions/')!==false?true:false)),
                        array('label'=>Yii::t('app','Gallery'), 'url'=>Yii::app()->createUrl('gallery/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/gallery/')!==false?true:false)),
                        array('label'=>Yii::t('app','Users'), 'url'=>Yii::app()->createUrl('users/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/users/')!==false?true:false)),
                        array('label'=>Yii::t('app','Settings'), 'url'=>Yii::app()->createUrl('settings/index'), 'active'=>(strpos(Yii::app()->request->requestUri,'/admin/settings/')!==false?true:false)),
                    ),
                ),
            array(
                'class'=>'bootstrap.widgets.BsNav',
                'type' => 'navbar',
                'htmlOptions'=>array('class'=>'pull-right'),
                'items'=>array(
                    array('label'=>Yii::t('app','Logout'), 'url'=>'/logout/'),
                    array('label'=>Yii::t('app','Settings'), 'url'=>'#', 'items'=>array(
                        array('label'=>Yii::t('app','Change Password'), 'url'=>'/user/changepassword/'),
                        array('label'=>Yii::t('app','Change e-mail'), 'url'=>'/user/changeemail/'),
                    )),
                    array('label'=>$label_lang, 'url'=>'#', 'items'=>$languages),
                ),
            ),
        ),
    ));
