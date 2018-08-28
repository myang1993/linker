<?php
return [
    'components' => [
        // 'db' => [
        //     'class' => 'yii\db\Connection',
        //     'dsn' => 'mysql:host=10.103.249.31;dbname=project',
        //     'username' => 'admin',
        //     'password' => 'admin',
        //     'charset' => 'utf8',
        // ],
//
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=47.98.241.235:3306;dbname=project',
            'username' => 'admin',
            'password' => 'linker@matt193',
            'charset' => 'utf8',
        ],
//        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=47.96.187.102:3306;dbname=project',
//            'username' => 'project',
//            'password' => 'Project123456#',
//            'charset' => 'utf8',
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/language',
                    'sourceLanguage' => 'en_US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
];
