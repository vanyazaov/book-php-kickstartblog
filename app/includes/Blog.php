<?php
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once ("Database.php");
require_once ("Markdown.php");
class Blog {
    protected $ksdb = '';
    protected $base = '';
    
    public function __construct() {
        $this->ksdb = new Database;
        $this->base = new stdClass;
        $this->base->url = "http://" . $_SERVER['SERVER_NAME'];
    }
}
