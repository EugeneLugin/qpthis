<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/city',
                    'tokens' => [
                        '{id}' => '<id:[\\w-]+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/warehouse',
                    'tokens' => [
                        '{id}' => '<id:[\\w-]+>'
                    ],
                    'pluralize'=>false
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/status',
                    'tokens' => [
                        '{id}' => '<id:[\\d]+>'
                    ],
                    'pluralize'=>false
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/item',
                    'tokens' => [
                        '{id}' => '<id:[\\w\\d]+>'
                    ],
                    'pluralize'=>false
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/order',
                    'tokens' => [
                        '{id}' => '<id:[\\d]+>'
                    ],
                    'pluralize'=>false,
                    'extraPatterns' => [
                        'GET counters' => 'counters',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/order_audit',
                    'tokens' => [
                        '{id}' => '<id:[\\d]+>'
                    ],
                    'pluralize'=>false
                ]
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ]
    ],
    'params' => $params,
];



