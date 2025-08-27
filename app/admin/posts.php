<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once('../includes/Posts.php');
$blog = new Posts();
