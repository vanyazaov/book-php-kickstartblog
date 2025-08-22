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
        $comments = new Comments;
        try {
            $query->execute();
            for ($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {
                    if ($key === 'content') {                     
                        $rowitem = $markdown->defaultTransform($rowitem);
                    }
                    if ($key === 'id') {                                        
                        $return[$i]['comments'] = $comments->commentNumber($rowitem);                                     
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
        $comments = new Comments;
        $postcomments = $comments->getComments($id);
        $template = 'view-post.php';
        include_once 'frontend/templates/' . $template;
    }
}

class Comments extends Blog {
    public function __construct() {
        parent::__construct();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment'])) {
            $this->addComment();
        }
    }
    public function commentNumber($postId) {
        $query = $this->ksdb->db->prepare("SELECT * FROM comments WHERE postid = ?");
        $comments = $return = array();
        try {
            $query->execute(array($postId));
            for($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {                
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $comments = $return;
        $commentnum = count($comments);
        if ($commentnum < 0) {
            $commentnum = 0;
        }
        return $commentnum;
    }
    public function getComments($postId) {
        $query = $this->ksdb->db->prepare("SELECT * FROM comments WHERE postid = ?");
        $comments = $return = array();
        try {
            $query->execute(array($postId));
            for($i = 0; $row = $query->fetch(); $i++) {
                $return[$i] = array();
                foreach ($row as $key => $rowitem) {                
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $comments = $return;
        return $comments;
    }
    public function addComment() {
        $status = $error = '';
        $array = $format = array();
        
        if (!empty($_POST['comment'])) {
            $comment = $_POST['comment'];
        }
        if (!empty($comment['fullname'])) {
            $array['name'] = $comment['fullname'];
            $format[] = ':fullname';
        } else {
            $error = 'Заполните поле "Комментарий"';      
        }

        if (!empty($comment['email'])) {
            $array['email'] = $comment['email'];
            $format[] = ':email';
        } else {
            $error = 'Заполните поле "Email"';
        }
        
        if (!empty($comment['context'])) {
            $array['comment'] = $comment['context'];
            $format[] = ':context';
        } else {
            $error = 'Заполните поле "Комментарий"';
        }
        
        if (!empty($comment['postid'])) {
            $array['postid'] = $comment['postid'];
            $format[] = ':postid';
        }
        if ($error) {
            header('Location: ' . $this->base->url . '?id='.$comment['postid'].'&savecomment=error');
            return;
        }
        
        $cols = $values = '';
        $i = 0;
        foreach ($array as $col => $data) {
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
            $query = $this->ksdb->db->prepare("INSERT INTO comments (".$cols.") VALUES (".$values.")");        
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
            $status = array('success' => 'Ваш комментарий успешно сохранен.');
            header('Location: ' . $this->base->url . '?id='.$comment['postid'].'&savecomment=success');
        } else {
            $status = array('error' => 'В процессе сохранения вашего комментария возникла ошибка. Пожалуйста, повторите попытку позднее.');
            header('Location: ' . $this->base->url . '?id='.$comment['postid'].'&savecomment=error');
        }
    }
}
