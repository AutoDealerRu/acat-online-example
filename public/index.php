<?php
if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

if (!function_exists('dd')){ function dd($val) { echo "<pre>";var_dump($val);echo "</pre>"; die(1); }}
if (!function_exists('dd2')){ function dd2($val) { echo "<pre>";var_dump($val);echo "</pre>"; }}

// Подключаем компаненты
require __DIR__ . '/../vendor/autoload.php';
session_start();

// Берем настройки и пихаем их для сервера
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Нужности
require __DIR__ . '/../src/dependencies.php';
require __DIR__ . '/Helper.php';

// Тут все пути
require __DIR__ . '/../src/routes.php';

// Старт
$app->run();
