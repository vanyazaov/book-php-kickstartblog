<?php
namespace App\User;

use App\Database;

class Blog {
    protected $ksdb = '';
    protected $base = '';
    
    public function __construct() {
        $this->ksdb = new Database();
        $this->base = new \stdClass();
        $this->base->url = "http://" . $_SERVER['SERVER_NAME'];
    }
}
