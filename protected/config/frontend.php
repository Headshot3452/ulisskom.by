<?php
return CMap::mergeArray
(
    require_once(dirname(__FILE__).'/main.php'),
    array(
                'controllerPath' => realpath(__DIR__ . '/../controllers/frontend'),
                'viewPath' => realpath(__DIR__ . '/../views/frontend'),
                'defaultController' => 'site',
                'import' => array(
                        'application.forms.*',
                ),
                'components' => array(
//                    'errorHandler'=>array(
//                        'errorAction'=>'site/error',
//                    ),
                    'urlManager' => array(
                            'urlFormat' => 'path',
                            'showScriptName' => false,
                            'caseSensitive'=>false,
                            'urlSuffix'=>'/',
                            'rules' => file_exists(__DIR__ . '/frontendUrlManager.php') ? require_once __DIR__ . '/frontendUrlManager.php' : array(),
                    ),
                    'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                                    array(
                                        'class'=>'CFileLogRoute',
                                        'levels'=>'error, warning',
                                    ),
                                     array(
                                        'class'=>'CProfileLogRoute',
                                        'levels'=>'profile',
                                        'enabled'=>true,
                                    ),

                        ),
                    ),
                )
        )
);
?>
