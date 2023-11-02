<?php
return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        'api' => [
            'host' => 'https://acat.online/api',   // Адрес АПИ сервиса
            'token' => '',                          // УКАЖИТЕ ВАШ ТОКЕН ВНУТРИ КОВЫЧЕК
            // Если каталог доступен например с "http://MouCauT.com/catalogs" то в ковычках будет 'catalogs'
            'urlBeforeCatalog' => '',
            'lang' => 'ru', // Работает у иномарок. Поддерживаемые языки: ru, en, de, bg, fr, es, he
            // поиск работает только по тем маркам, у кого searchParts = true
            'displayPartsSearchOnMainPage' => false, // Показывать поиск по названию/номеру детали на главной странице
        ],
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
