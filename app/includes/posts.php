<?php
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once ("database.php");
require_once ("markdown.php");
class Blog {
    public $ksdb = '';
    public $base = '';
    public function __construct() {
        $this->ksdb = new Database;
        $this->base = new stdClass;
        $this->base->url = "http://" . $_SERVER['SERVER_NAME'];
    }
}

class Posts extends Blog {
    public function __construct() {
        parent::__construct();
        $this->comments = new Comments();
        if (!empty($_GET['id'])) {
            $this->viewPost($_GET['id']);
        } else {
            $this->getPosts();
        }
    }
    public function getPosts() {
        $id = 0;
        $posts = $return = array();
        $template = '';
        $query = $this->ksdb->db->prepare("SELECT * FROM posts");
        $markdown = new Michelf\Markdown();
        try {
            $query->execute();
            for ($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {
                    if ($key == 'content') {                     
                        $rowitem = $markdown->defaultTransform($rowitem);
                    } 
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $posts = $return;
        $template = 'list-posts.php';
        include_once 'frontend/templates/' . $template;
    }
    public function viewPost($postId) {
        $id = $postId;
        $posts = $return = array();
        $template = '';
        $query = $this->ksdb->db->prepare("SELECT * FROM posts WHERE id = ?");
        $markdown = new Michelf\Markdown();
        try {
            $query->execute(array($id));
            for($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {
                    if ($key == 'content') {
                        $rowitem = $markdown->defaultTransform($rowitem);
                    }                   
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $posts = $return;
        $template = 'view-post.php';
        include_once 'frontend/templates/' . $template;
    }
}

class Comments extends Blog {
    public function __construct() {
        parent::__construct();
    }
    public function commentNumber($postId) {}
    public function getComments($postId) {}
    public function addComment() {}
}
