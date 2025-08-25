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
    public $comments = '';
    public $markdown = '';
    
    public function __construct() {
        parent::__construct();
        $this->comments = new Comments();
        $this->markdown = new Michelf\Markdown();
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
        $return = $this->ksdb->dbselect('posts', array('*'));
        foreach ($return as $key => $post) {
            $posts[$i] = array();
            foreach ($post as $key => $rowitem) {              
                if ($key === 'content') {                     
                    $rowitem = $this->markdown->defaultTransform($rowitem);
                }
                if ($key === 'id') {                                        
                    $posts[$i]['comments'] = $this->comments->commentNumber($rowitem);                                     
                } 
                $posts[$i][$key] = $rowitem;
            }
            $i++;        
        }
        $template = 'list-posts.php';
        include_once 'frontend/templates/' . $template;
    }
    public function viewPost($postId) {
        $posts = array();
        $template = '';
        $posts = $this->ksdb->dbselect('posts', array('*'), array('id' => $postId));
        $posts[0]['content'] = $this->markdown->defaultTransform($posts[0]['content']);
        $postcomments = $this->comments->getComments($postId);
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
        $comments = $this->ksdb->dbselect('comments', array('*'), array('postid' => $postId));
        $commentnum = count($comments);
        if ($commentnum < 0) {
            $commentnum = 0;
        }
        return $commentnum;
    }
    public function getComments($postId) {
        return $this->ksdb->dbselect('comments', array('*'), array('postid' => $postId));
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
        $add = $this->ksdb->dbadd('comments', $array, $format);
        if (!empty($add) && $add > 0) {
            $status = array('success' => 'Ваш комментарий успешно сохранен.');
            header('Location: ' . $this->base->url . '?id='.$comment['postid'].'&savecomment=success');
        } else {
            $status = array('error' => 'В процессе сохранения вашего комментария возникла ошибка. Пожалуйста, повторите попытку позднее.');
            header('Location: ' . $this->base->url . '?id='.$comment['postid'].'&savecomment=error');
        }
    }
}
