<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once('database.php');
require_once ("markdown.php");
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
    public $markdown = '';
    
    public function __construct() {
        parent::__construct();
        $this->markdown = new Michelf\Markdown();
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
        $return = $this->ksdb->dbselect('posts', array('*'));
        foreach ($return as $key => $post) {
            $posts[$i] = array();
            foreach ($post as $key => $rowitem) {              
                if ($key === 'content') {                     
                    $rowitem = $this->markdown->defaultTransform($rowitem);
                }
                $posts[$i][$key] = $rowitem;
            }
            $i++;        
        }
        require_once 'templates/manageposts.php';
    }
    public function editPosts() {
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ' . $this->base->url . '/admin/posts.php?edit=notfound');
        }
        $id = $_GET['id'];
        $posts = $return = array();
        $template = '';
        $posts = $this->ksdb->dbselect('posts', array('*'), array('id' => $id));
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
        if (!empty($post['title'])) {
            $array['title'] = $post['title'];

            $format[] = ':title';
        }        
        if (!empty($post['content'])) {
            $array['content'] = $post['content'];
            $format[] = ':content';
        }
        if (isset($post['id']) && is_numeric($post['id']) && $post['id'] > 0) {          
            $add  = $this->ksdb->dbupdate('posts', $array, $format, $post['id']);
        } else {
            $add  = $this->ksdb->dbadd('posts', $array, $format);
        }
              
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
            $delete = $this->ksdb->dbdelete('posts', $_GET['id']);
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
        if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
            $this->deleteComment();
        } else {
            $this->listComments();
        }
    }
    public function listComments() {
        $comments = $this->ksdb->dbselect('comments', array('*'));       
        require_once 'templates/managecomments.php';
    }
    public function deleteComment() {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $delete = $this->ksdb->dbdelete('comments', $_GET['id']);
            if (!empty($delete) && $delete > 0) {
                header("Location: " . $this->base->url . "/admin/posts.php?delete=success");
            } else {
                header("Location: " . $this->base->url . "/admin/posts.php?delete=error");
            }
        }    
    }
}

$admin = new Adminpanel();
