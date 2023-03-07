<?php

return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__.'/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name'  => 'Api',
            'path'  => isset($_ENV['docker']) ? 'php://stdout' : __DIR__.'/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

       
        // Database settings
        'db_trans' => [
            'driver' => DB_TRANS_DRIVER,
            'host' => DB_TRANS_HOST,
            'database' => DB_TRANS_NAME,
            'username' => DB_TRANS_USERNAME,
            'password' => DB_TRANS_PASSWORD,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
        
    ]
];
