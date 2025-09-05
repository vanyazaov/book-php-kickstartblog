<?php
namespace Adminpanel;

use Michelf\Markdown;

class Posts extends Adminpanel {
    private $markdown = null;
    
    public function __construct() {
        parent::__construct();
        $this->markdown = new Markdown();
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
        require_once APP_PATH . 'admin/templates/manageposts.php';
    }
    public function editPosts() {
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ' . $this->base->url . '/admin/posts?edit=notfound');
        }
        $id = $_GET['id'];
        $posts = $return = array();
        $template = '';
        $posts = $this->ksdb->dbselect('posts', array('*'), array('id' => $id));
        include_once APP_PATH . 'admin/templates/editpost.php';
    }
    public function addPost() {
        require_once APP_PATH . 'admin/templates/newpost.php';
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
            header('Location: ' . $this->base->url . '/admin/posts?save=success');
        } else {
            $status = array('error' => 'В процессе сохранения вашего сообщения возникла ошибка. Пожалуйста, повторите попытку позднее.');
            header('Location: ' . $this->base->url . '/admin/posts?save=error');
        }
        
    }
    public function deletePost() {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $delete = $this->ksdb->dbdelete('posts', $_GET['id']);
            if (!empty($delete) && $delete > 0) {
                header("Location: " . $this->base->url . "/admin/posts?delete=success");
            } else {
                header("Location: " . $this->base->url . "/admin/posts?delete=error");
            }
        }
    }
}
