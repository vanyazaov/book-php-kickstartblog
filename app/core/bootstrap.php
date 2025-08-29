<?php

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
