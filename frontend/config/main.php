<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
    
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'rules' => [
                'contact-us'          => 'site/contact',
                'about-us'            => 'site/about',
                'fast-boats'          => 'content/fast-boats',
                'destinations'        => 'content/destinations',
                'ports'               => 'content/ports',
                'hotels'              => 'content/hotels',
                'articles'            => 'content/articles',
                'fast-boats/<slug>'   => 'content/view',
                'articles/<slug>'     => 'content/view',
                'destinations/<slug>' => 'content/view',
                'ports/<slug>'        => 'content/view',
                'hotels/<slug>'       => 'content/view',
            ],
            'normalizer'=>[
            'class' => 'yii\web\UrlNormalizer',
            'collapseSlashes' => true,
            'normalizeTrailingSlash' => true,
            ]

        ],
         'urlAgoda' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'https://www.agoda.com/pages/agoda/default/destinationsearchresult.aspx?cid=1605135&pcs=4&hl=en&sort=priceLowToHigh',
        ],

        'gilitransfers'=>[
            'class'=>'common\components\Gilitransfers',
        ],
        
    ],
    'params' => $params,
];
