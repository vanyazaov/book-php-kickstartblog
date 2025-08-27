<?php

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
