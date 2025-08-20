<?php
class Database {
    public $dbserver = '';
    public $username = '';
    public $password = '';
    public $database = '';
    public $db = '';
    
    public function __construct() {
        $this->dbserver = 'db'; // Хост базы данных. В рамках окружения докера сервис имеет имя "db"
        $this->username = 'docker'; // Логин пользователя базы данных
        $this->password = 'password'; // Пароль пользователя базы данных
        $this->database = 'kickstartblog'; // Название базы данных
        $this->db = new PDO("mysql:host=".$this->dbserver.";dbname=".$this->database, $this->username, $this->password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function dbselect($table, $select, $where = NULL) {}
    public function dbadd($tablename, $insert, $format) {}
    public function dbupdate($table, $insert, $where) {}
}
