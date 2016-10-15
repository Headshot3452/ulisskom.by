<?php
    return array(
        'urlManagerGenerator' => array(
            'module_config_dir'       => 'application.config.module_config',
            'data_dir'                => 'application.data',
            'url_manager_config'      => 'urlManagerConfig.json',
            'url_manager_config_bckp' => 'urlManagerConfig.json.bckp',
            'url_manager'             => 'frontendUrlManager.php',
            'url_manager_config_bckp' => 'frontendUrlManager.php.bckp',
            'write_backup'            => false,
        ),

    'upload' => array(
        'modules'  => array(
            'temp' => 'application.upload.modules.temp.'
        ),
        'media'   => array(
            'images'  => array(
                'path'    => 'webroot.data.media.images',
                'webpath' => '/data/media/images/',
            ),
            'files'   => array(
                'path'    => 'webroot.data.media.files',
                'webpath' => '/data/media/files/',
            ),
        )
    ),
    'api' => array('actions' => array('storage' => 'http://storage.ideadrive.iwl/api/store/'),
        'auth' => array(
            'id'   => '2',
            'key'  => '225520880',
        ),
    ),

    'catalog_page' => 7,

    'noavatar' => 'images/noavatar.png',
    'noimage'  => 'images/noimage.png',
    'no-image'  => 'images/no-image.png',

    'pages' => array(
        'vhod_dveri'    => '2',
        'komn_dveri'    => '3',
        'furnitura'     => '4',
        'gde_kypit'     => '5',
        'akcii'         => '6',
        'uslugi'        => '7',
        'novosti'       => '10',
    ),

    'icons' => array(
        'main_settings' => 'images/icon-admin/main_settings.png',
        'permission'    => 'images/icon-admin/permission.png'
    ),

    'watermark' => '/images/watermark.png',
        'site'=>array(
            'allow_register_admin' => false,
            'allow_register'       => true,
        ),

        'multi_language'=>false,
        'phone'=>array(
            'mask'   => '+375(99)999-99-99',
            'regexp' => '/\+375\(\d{2}\)\d{3}\-\d{2}\-\d{2}/isU',
        ),

        'settings_id'=>1,

        'allowWidgets'=>array(
            'AskAnswerWidget',
            'BannerDescriptionWidget',
            'BlockWidget',
            'CarouselGalleryWidget',
            'CarouselProductsWidget',
            'CatalogTreeViewWidget',
            'CatalogTreeWidget',
            'MapWidget',
            'MenuWidget',
            'NewsLastWidget',
            'SliderProductsWidget',
            'SliderWidget',
            'ReviewWidget',
            'FeedbackWidget',
            'AskAnswerSearchWidget',
            'CarouselProductsReleatedWidget',
        ),
    );
?>