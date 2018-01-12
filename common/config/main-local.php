<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=db_gilitransfers',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

        'mailReservation' => [
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => false,
        'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.traviora.com',
                'username' =>'reservation@traviora.com',
                'password' =>'reservation1994',
                'port' => '465',
                'encryption' => 'ssl',
        ],
        ],
    ],
];
