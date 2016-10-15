<?php
    // uncomment the following to define a path alias
    // Yii::setPathOfAlias('local','path/to/local-folder');

    // This is the main Web application configuration. Any writable
    // CWebApplication properties can be configured here.
    return array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'CMS',
        'sourceLanguage' => 'ru_ru',
        'language' => 'ru',
        'charset' => 'utf-8',
//         preloading 'log' component
//         'preload' => array('log', 'debug'),

        // autoloading model and component classes

        'import' => array(
            'application.models.*',
            'application.components.*',
            'application.components.form.*',
            'application.widgets.*',
            'application.events.*',

            'bootstrap.behaviors.*',
            'bootstrap.helpers.*',
            'bootstrap.components.*',
            'bootstrap.widgets.*',
            'application.extensions.ImageHandler.*'
        ),
        'aliases' => array(
            'bootstrap' => dirname(__FILE__) . '/../extensions/bootstrap/',
            'actionsBackend' => dirname(__FILE__) . '/../actions/backend/',
            'email' => dirname(__FILE__) . '/../views/email/',
        ),

        'defaultController' => 'site',

        'modules' => array(
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'admin',
                'ipFilters' => '',
                'newFileMode' => 0666,
                'newDirMode' => 0777,
            ),
        ),

        // application components
        'components' => array(
            // uncomment the following to use a MySQL database
            'db' => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : array(),
//                'errorHandler'=>array(
    //                // use 'site/error' action to display errors
//                    'errorAction'=>'site/index',
//                ),
            'urlManager' => array(
                'class' => 'UrlManager',
                'urlFormat' => 'path',
                'showScriptName' => false,
                'caseSensitive' => false,
                'useStrictParsing' => true,
                'urlSuffix' => '/',
                'rules' => array(
                    'gii' => 'gii',
                    'gii/<controller:\w+>' => 'gii/<controller>',
                    'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                ),
            ),
            'authManager' => array(
                'class' => 'PhpAuthManager',
                'defaultRoles' => array('guest'),
            ),
            'user' => array(
                'class' => 'WebUserFront',
                'allowAutoLogin' => true,
                'autoRenewCookie' => true,
                'loginUrl' => '/login',
                'onLogin' => array('CoreEvents', 'onLogin'),
            ),
            'session' => array(
                'class' => 'CDbHttpSession',
                'connectionID' => 'db',
                'sessionTableName' => 'users_sessions',
                'autoCreateSessionTable' => true,
            ),
            'clientScript' => array(
                'packages' => array(
                    'owlcarousel' => array(
                        'basePath'=>'webroot.js.owlcarousel',
                        'js'=>array('js/owl.carousel.js'),
                        'css'=>array('css/owl.carousel.css', 'css/owl.theme.css', 'css/owl.transitions.css'),
                        'depends'=>array('jquery'),
                    ),
                    'elasticgallery' => array(
                        'basePath'=>'webroot.js.ResponsiveImageGallery',
                        'js'=>array('js/jquery.tmpl.min.js','js/jquery.easing.1.3.js','js/jquery.elastislide.js','js/gallery.js'),
                        'css'=>array('css/elastislide.css', 'css/style.css'),
                        'depends'=>array('jquery'),
                    ),
                    'hint' => array(
                        'basePath' => 'webroot.css.hint',
                        'css' => array('hint.css'),
                    ),
                    'boot-select' => array(
                        'basePath' => 'webroot.js.boot-select',
                        'js' => array('js/bootstrap-select.js'),
                        'css' => array('css/bootstrap-select.css'),
                        'depends' => array('jquery')
                    ),
                    'bootstrap' => array(
                        'basePath' => 'webroot.css.bootstrap',
                        'js' => array('js/bootstrap.min.js'),
                        'css' => array('css/bootstrap.min.css', 'css/bootstrap-theme.min.css'),
                        'depends' => array('jquery', 'jquery.ui'),
                    ),
                    'bootstrap_frontend' => array(
                        'basePath' => 'webroot.css.bootstrap',
                        'js' => array('js/bootstrap.min.js'),
                        'css' => array('css/bootstrap.min.css'),
                        'depends' => array('jquery', 'jquery.ui'),
                    ),
                    'lightbox' => array(
                        'basePath' => 'webroot.js.lightbox',
                        'js' => array('js/lightbox.min.js'),
                        'css' => array('css/lightbox.css'),
                        'depends' => array('jquery'),
                    ),
                    'jquery' => array(
                        'basePath' => 'webroot.js.jquery',
                        'js' => array(YII_DEBUG ? 'jquery-1.11.1.js' : 'jquery-1.11.1.min.js', 'datepicker-ru.js'),
                    ),
                    'sweet' => array(
                        'basePath' => 'webroot.js.sweet',
                        'js' => array('sweetalert2.min.js'),
                        'css' => array('sweetalert2.min.css'),
                        'depends' => array('jquery'),
                    ),
                    'tagit' => array(
                        'basePath' => 'webroot.js.tag-it',
                        'js' => array(YII_DEBUG ? 'js/tag-it.js' : 'js/tag-it.min.js'),
                        'css' => array('css/jquery.tagit.css', 'css/tagit.ui-zendesk.css'),
                        'depends' => array('jquery', 'jquery.ui'),
                    ),
                    'ractivejs' => array(
                        'basePath' => 'webroot.js.ractive',
                        'js' => array('ractive.js'),
                    ),
                    'jquery.ui' => array(
                        'basePath' => 'webroot.js.jqueryui',
                        'js' => array('jquery-ui.min.js'),
                    ),
                    'jstorage' => array(
                        'basePath' => 'webroot.js.jstorage',
                        'js' => array('jstorage.js'),
                        'depends' => array('jquery'),
                    ),
                    'function' => array(
                        'basePath' => 'webroot.js.function',
                        'js' => array('function.js'),
                    ),
                    'cart' => array(
                        'basePath' => 'webroot.js.cart',
                        'js' => array('Storage.js', 'Cart.js', 'Product.js', 'controller.js'),
                        'depends' => array('jquery', 'function', 'cookie', 'jstorage'),
                    ),
                    'slider-slick' => array(
                        'basePath' => 'webroot.js.slick',
                        'js' => array('slick.min.js'),
                        'css' => array('slick.css'),
                        'depends' => array('jquery'),
                    ),
                )
            ),
            'mailer' => array(
                // for php mail
                'class' => 'application.extensions.mailer.PhpMailer',
            ),
            'image' => array(
                'class' => 'application.extensions.image.CImageComponent',
                // GD or ImageMagick
                'driver' => 'GD',
                'params' => array('directory' => 'data'),
            ),
            'ih' => array(
                'class' => 'application.extensions.ImageHandler.CImageHandler',
            ),
            'curl' => array(
                'class' => 'application.extensions.curl.Curl',
            ),
            'priceParser' => array(
                'class' => 'application.extensions.priceParser.PriceParser',
            ),
            'format' => array(
                'class' => 'system.utils.CFormatter',
                'numberFormat' => array('decimals' => 0, 'decimalSeparator' => '', 'thousandSeparator' => ' '),
            ),
//            'bootstrap'=>array(
//                'class'=>'bootstrap.components.TbApi',
//            ),
//              minimaizer css && js DEBUG false
//            'clientScript'=>array(
//                'class'=>'application.components.MinifyClientScript',
//            ),
            'debug' => array(
                'class' => 'ext.yii2-debug.Yii2Debug',
                'allowedIPs' => array('192.168.1.70', '192.168.1.71', '127.0.0.1'),
                'panels' => array(
                    'db' => array(
                        // Отключить подсветку SQL
                        'highlightCode' => true,
                        // Отключить подстановку параметров в SQL-запрос
                        'insertParamValues' => true,
                    ),
                ),
            ),
//            'paypal' => array(
//                    'class' => 'ext.paypal.PayPal',
//                    'clientId'=>'AdLjNxArtJtYsl6ZkC0SpdC_uDtGQv4ib38VkK4bHLXGzkEPlDOm1_4bK3Re',
//                    'secret'=>'EDsAoRDWgzi5AqnlU6lSL4flECrvDGi7nMW63yYDJTFqAd48_vy1Q4V64mEm',
//            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning',
                    ),
                    array(
                        'class' => 'CProfileLogRoute',
                        'levels' => 'profile',
                        'enabled' => false,
                    ),
                ),
            ),
        ),
        'params' => file_exists(__DIR__ . '/params.php') ? require_once __DIR__ . '/params.php' : array(),
    );