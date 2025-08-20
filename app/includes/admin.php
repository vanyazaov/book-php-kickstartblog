<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once('database.php');

class Adminpanel {
    public function __construct() {
        $inactive = 600;
        if (isset($_SESSION["kickstart_login"])) {
            $sessionTTL = time() - $_SESSION['timeout'];
            if ($sessionTTL > $inactive) {
                session_unset();
                session_destroy();
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php?status=inactive');
            }
        }
        $_SESSION['timeout'] = time();
        $login = $_SESSION['kickstart_login'];
        if (empty($login)) {
            session_unset();
            session_destroy();
            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php?status=logout');
        } else {
            $this->ksdb = new Database;
            $this->base = (object) '';
            $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];        
        }
    }
}

class Posts extends Adminpanel {
    public function __construct() {
        parent::__construct();
        if (!empty($_GET['action'])) {
            switch ($_GET['action']) {
                case 'create': $this->addPost(); break;
                case 'edit': $this->editPosts(); break;
                case 'save': $this->savePost(); break;
                case 'delete': $this->deletePost(); break;
                default: $this->listPosts();
            }
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
    public function editPosts() {
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ' . $this->base->url . '/admin/posts.php?edit=notfound');
        }
        $id = $_GET['id'];
        $posts = $return = array();
        $template = '';
        $query = $this->ksdb->db->prepare("SELECT * FROM posts WHERE id = ?");
        try {
            $query->execute(array($id));
            for($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $posts = $return;
        include_once 'templates/editpost.php';
    }
    public function addPost() {
        require_once 'templates/newpost.php';
    }
    public function savePost() {
        $array = $format = $return = array();
        if (!empty($_POST['post'])) {
            $post = $_POST['post'];
        }        
        if (!empty($post['content'])) {
            $array['content'] = $post['content'];
            $format[] = ':content';
        }
        if (isset($post['id']) && is_numeric($post['id']) && $post['id'] > 0) {          
            $trigger_update = true;
        } else {
            $trigger_update = false;
        }
       
        $cols = $values = '';
        $i = 0;
        foreach ($array as $col => $data) {
            if ($i == 0) {
                if ($trigger_update) {
                    $cols .= $col . '=' . $format[$i];
                } else {
                    $cols .= $col;
                    $values .= $format[$i];
                }
            } else {
                if ($trigger_update) {
                    $cols .= ',' . $col . '=' . $format[$i];
                } else {
                    $cols .= ',' . $col;
                    $values .= ',' . $format[$i];
                }               
            }
            $i++;
        }
        try {
            if ($trigger_update) {
                $query = $this->ksdb->db->prepare("UPDATE posts SET $cols WHERE id = :id");
                $array['id'] = $post['id'];
                $format[] = ':id';
                $i++;
            } else {
                $query = $this->ksdb->db->prepare("INSERT INTO posts (".$cols.") VALUES (".$values.")");
            }          
            for($c=0;$c<$i;$c++) {
                $query->bindParam($format[$c], ${'var'.$c});
            }
            $z = 0;
            foreach ($array as $col => $data) {
                ${'var'.$z} = $data;
                $z++;
            }
            $result = $query->execute();
            $add = $query->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $query->closeCursor();
        $this->ksdb->db = null;
        if (!empty($add)) {
            $status = array('success' => 'Ваше сообщение успешно сохранено.');
            header('Location: ' . $this->base->url . '/admin/posts.php?save=success');
        } else {
            $status = array('error' => 'В процессе сохранения вашего сообщения возникла ошибка. Пожалуйста, повторите попытку позднее.');
            header('Location: ' . $this->base->url . '/admin/posts.php?save=error');
        }
        
    }
    public function deletePost() {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $query = "DELETE FROM `posts` WHERE id = ?";
            $stmt = $this->ksdb->db->prepare($query);
            $stmt->execute(array($_GET['id']));
            $delete = $stmt->rowCount();
            $this->ksdb->db = null;
            if (!empty($delete) && $delete > 0) {
                header("Location: " . $this->base->url . "/admin/posts.php?delete=success");
            } else {
                header("Location: " . $this->base->url . "/admin/posts.php?delete=error");
            }
        }
    }
}

class Comments extends Adminpanel {
    public function __construct() {
        parent::__construct();
    }
    public function listComments() {}
    public function deleteComment() {}
}

$admin = new Adminpanel();
