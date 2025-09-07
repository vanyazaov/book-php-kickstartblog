<?php

namespace Core;


/**
* Загружаем основные компоненты движка: конфигурацию, автозагружчик и другое
*/
require 'kernel.php';

header("Content-Type: text/html;charset=utf-8");
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}

if (file_exists($path = APP_PATH.'bootstrap'.EXT))
{
	require_once $path;
}
if (file_exists($app_config = APP_PATH.'config.php'))
{
	require $app_config;
}

date_default_timezone_set(APP_CONFIG_TIMEZONE);

// Регистрирует обработчик исключений. 
// Все необработанные движком ошибки передаются в это замыкание.
set_exception_handler(function($e)
{
	Error::exception($e);
});

/**
 * Регистрирует обработчик ошибок PHP. Все ошибки PHP будут попадать в этот
 * обработчик, который преобразует ошибку в объект ErrorException
 * и передаст это исключение в обработчик исключений.
 */
set_error_handler(function($code, $error, $file, $line)
{
	Error::native($code, $error, $file, $line);
});

// Регистрирует функцию, вызываемую в конце работы скрипта
// или при фатальной ошибке. Преобразует ошибки в исключения
// и передаёт их основному обработчику.
register_shutdown_function(function()
{
	Error::shutdown();
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = (($uri = trim($uri, '/')) !== '') ? $uri : '/';
$_SERVER['route'] = $uri;

switch ($uri) {
    case '/': require_once APP_PATH . 'index.php'; break;
    case 'login': require_once APP_PATH . 'login.php'; break;
    case 'admin': require_once APP_PATH . 'admin/posts.php'; break;
    case 'admin/posts': require_once APP_PATH . 'admin/posts.php'; break;
    case 'admin/comments': require_once APP_PATH . 'admin/comments.php'; break;
}
