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
    if (($slash_pos = strpos($class, '\\')) !== false) {
        $class = substr($class, $slash_pos+1);
    }
    require_once APP_PATH . "includes/{$class}.php";
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
