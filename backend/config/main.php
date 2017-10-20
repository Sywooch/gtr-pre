<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
            
            'redactor' => 'yii\redactor\RedactorModule',
            'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
             'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
            ],
            'admin' => [
                'class' => 'mdm\admin\Module',
            //    'layout' => 'left-menu', // it can be '@path/to/your/layout'.
                'controllerMap' => [
                    'assignment' => [
                        'class' => 'mdm\admin\controllers\AssignmentController',
                        'userClassName' => 'backend\models\User',
                        'idField' => 'id'
                    ],
                    'other' => [
                        'class' => 'path\to\OtherController', // add another controller
                    ],
                ],
            ],
    ],
    'components' => [
        
    
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
           // 'loginUrl' => ['admin/user/login'],
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
             'enableStrictParsing' => false,
            'rules' => [
            '/trip/add-dayli/<date>'                 => 'trip/add-dayli',
            '<controller:\w+>/<id:\d+>'              => '<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            '/trip/index/<month>'                    => 'trip/index',
            ],
        ],

        'gilitransfers'=>[
            'class'=>'common\components\Gilitransfers',
        ],
        
    ],
    'params' => $params,
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [ 
        'site/*',
        ]
    ]
];
