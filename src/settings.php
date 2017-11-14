<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        'api' => [
            'host' => 'https://acat.online/api',   // Адрес АПИ сервиса
            'token' => '',                          // УКАЖИТЕ ВАШ ТОКЕН ВНУТРИ КОВЫЧЕК
            // Если каталог доступен например с "http://MouCauT.com/catalogs" то в ковычках будет 'catalogs'
            'urlBeforeCatalog' => ''
        ],
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
