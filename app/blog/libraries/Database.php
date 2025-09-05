<?php

class Database {
    private $dbserver = '';
    private $username = '';
    private $password = '';
    private $database = '';
    private $db = '';
    
    public function __construct() {
        $this->dbserver = 'db'; // Хост базы данных. В рамках окружения докера сервис имеет имя "db"
        $this->username = 'docker'; // Логин пользователя базы данных
        $this->password = 'password'; // Пароль пользователя базы данных
        $this->database = 'kickstartblog'; // Название базы данных
        $this->db = new \PDO("mysql:host=".$this->dbserver.";dbname=".$this->database, $this->username, $this->password);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    public function dbselect($table, $select, $where = NULL) {
        if (is_array($select)) {
            $select = implode(',', $select);
        } else {
            $select = '*';
        }
        $where_str = '';
        if (!is_null($where) && is_array($where)) {
            $where_arr = array();
            foreach ($where as $field => $value) {
                $where_arr[] = "$field = ?";
            }
            $where_str = 'WHERE ' . implode(' AND ', $where_arr);
        } else {
            $where = array();
        }       
        $stmt = $this->db->prepare("SELECT $select FROM $table $where_str");
        $return = array();
        try {
            $stmt->execute(array_values($where));          
            for($i = 0; $row = $stmt->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {                
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch(PDOException $e) {          
            return $e->getMessage();
        }
        return $return;    
    }
    public function dbadd($tablename, $insert, $format) {
        $cols = $values = '';
        $i = 0;
        foreach ($insert as $col => $data) {
            if ($i == 0) {
                $cols .= $col;
                $values .= $format[$i];
            } else {
                $cols .= ',' . $col;
                $values .= ',' . $format[$i];              
            }
            $i++;
        }
        try {
            $stmt = $this->db->prepare("INSERT INTO $tablename (".$cols.") VALUES (".$values.")");        
            for($c=0;$c<$i;$c++) {
                $stmt->bindParam($format[$c], ${'var'.$c});
            }
            $z = 0;
            foreach ($insert as $col => $data) {
                ${'var'.$z} = $data;
                $z++;
            }
            $result = $stmt->execute();
            $add = $stmt->rowCount();
            $stmt->closeCursor();
            return $add;
        } catch (PDOException $e) {
            return $e->getMessage();
        }    
    }
    public function dbupdate($table, $update, $format, $where) {
        if (!is_numeric($where)) {
            return 'Ошибка обновления записи. Не передан идентификатор записи.';
        }
        $cols = $values = '';
        $i = 0;
        foreach ($update as $col => $data) {
            if ($i == 0) {
                $cols .= $col . '=' . $format[$i];
            } else {
                $cols .= ',' . $col . '=' . $format[$i];             
            }
            $i++;
        }
        try {
            $stmt = $this->db->prepare("UPDATE posts SET $cols WHERE id = :id");
            $update['id'] = $where;
            $format[] = ':id';
            $i++;
                   
            for($c=0;$c<$i;$c++) {
                $stmt->bindParam($format[$c], ${'var'.$c});
            }
            $z = 0;
            foreach ($update as $col => $data) {
                ${'var'.$z} = $data;
                $z++;
            }
            $result = $stmt->execute();
            $add = $stmt->rowCount();
            $stmt->closeCursor();
            return $add;
        } catch (PDOException $e) {
            return $e->getMessage();
        }   
    }
    public function dbdelete($table, $where) {
        if (!is_numeric($where)) {
            return 'Ошибка удаления записи. Не передан идентификатор записи.';
        }
        $stmt = $this->db->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute(array($where));
        $delete = $stmt->rowCount();
        $stmt->closeCursor();
        return $delete; 
    }
}
