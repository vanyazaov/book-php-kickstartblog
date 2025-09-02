<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
ini_set('display_errors', 1);
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
spl_autoload_register('load');

function load($class) {
    // Первый символ слеша в названии класса
    $slash = strpos($class, '\\');
    // Если существует, то берем namespace
    if ($slash !== false) {
        $namespace = substr($class, 0, $slash);
        // Переделываем слеши в путь к файлу
        $classname = substr($class, $slash + 1);
        $file = str_replace(array('\\', '_'), '/', $classname);
        // составляем путь к файлу
        $app_path = APP_PATH . 'includes'.DS.$file.'.php';
        $app_vendor_path = APP_PATH . 'includes'.DS.'vendor'.DS.$namespace.DS. $file.'.php';
        if (file_exists($app_path)) {
            return require $app_path;
        } elseif (file_exists($app_vendor_path)) {
            return require $app_vendor_path;
        }        
    }
    // Пробуем подключить без namespace
    $file = str_replace(array('\\', '_'), '/', $class);
    $app_path = APP_PATH . 'includes'.DS.$file.'.php';
    return require $app_path;
}

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
