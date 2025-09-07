<?php
namespace User;

use Michelf\Markdown;

class Posts extends Blog {
    private $comments = null;
    private $markdown = null;
    
    public function __construct() {        
        parent::__construct();
        $this->comments = new Comments();
        $this->markdown = new Markdown();
        if (!empty($_GET['id'])) {
            $this->viewPost($_GET['id']);
        } else {
            $this->getPosts();
        }
    }
    public function getPosts() {
        $i = 0;
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
        include_once APP_PATH . 'frontend/templates/' . $template;
    }
    public function viewPost($postId) {
        $posts = array();
        $template = '';
        $posts = $this->ksdb->dbselect('posts', array('*'), array('id' => $postId));
        $posts[0]['content'] = $this->markdown->defaultTransform($posts[0]['content']);
        $postcomments = $this->comments->getComments($postId);
        $template = 'view-post.php';
        include_once APP_PATH . 'frontend/templates/' . $template;
    }
}
