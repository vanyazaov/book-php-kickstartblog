<?php

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
        require_once APP_PATH . 'admin/templates/managecomments.php';
    }
    public function deleteComment() {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $delete = $this->ksdb->dbdelete('comments', $_GET['id']);
            if (!empty($delete) && $delete > 0) {
                header("Location: " . $this->base->url . "/admin/posts?delete=success");
            } else {
                header("Location: " . $this->base->url . "/admin/posts?delete=error");
            }
        }    
    }
}
