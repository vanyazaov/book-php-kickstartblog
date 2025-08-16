<?php
session_start();
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once('database.php');

class Adminpanel {
    public function __construct() {
        $this->ksdb = new Database;
        $this->base = (object) '';
        $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];
    }
}

class Posts extends Adminpanel {
    public function __construct() {
        parent::__construct();
        if (isset($_GET['action']) && $_GET['action'] == 'create') {
            $this->addPost();
        } else {
            $this->listPosts();
        }      
    }
    public function listPosts() {
        $posts = $return = array();
        $query = $this->ksdb->db->prepare("SELECT * FROM posts");
        try {
            $query->execute();
            for ($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $posts = $return;
        require_once 'templates/manageposts.php';
    }
    public function editPosts() {}
    public function addPost() {
        require_once 'templates/newpost.php';
    }
    public function savePost() {}
    public function deletePost() {}
}

class Comments extends Adminpanel {
    public function __construct() {
        parent::__construct();
    }
    public function listComments() {}
    public function deleteComment() {}
}

$admin = new Adminpanel();
