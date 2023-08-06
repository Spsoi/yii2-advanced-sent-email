<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log', 
        'queue',
        // 'queue2'
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '172.22.0.1'], // разрешить ip
        ],
    ],
    'components' => [
        'request' => [
            // 'csrfParam' => '_csrf-backend',
            'baseUrl'=>'/backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
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
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    // 'categories' => ['yii\swiftmailer\Mailer'],
                    'logFile' => '@backend/runtime/logs/app.log',
                ],
            ],
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtps',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => 465,
                'dsn' => 'native://default',
            ],
            'viewPath' => '@common/mail',
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'channel' => 'queue',
            'as log' => 'yii\queue\LogBehavior', 
        ],
        // 'queue2' => [
        //     'class' => \yii\queue\db\Queue::class,
        //     'strictJobType' => false,
        //     'serializer' => \yii\queue\serializers\JsonSerializer::class,
        //     'mutex' => \yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
        // ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                [
                    'pattern' => 'user/register',
                    'route' => 'user/register',
                    'verb' => 'POST',
                ],
            ],
        ],
        
    ],
    'params' => $params,
];
