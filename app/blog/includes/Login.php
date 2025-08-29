<?php

class Login {
    private $ksdb = null;
    private $base = null;
    
    public function __construct() {
        $this->ksdb = new Database;
        $this->base = (object) '';
        $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];
        $this->index();
    }
    public function index() {
        if (!empty($_GET['status']) && $_GET['status'] == 'logout') {
            session_unset();
            session_destroy();
            $error = 'Ваш сеанс завершён. Пожалуйста, авторизуйтесь снова.';
            require_once APP_PATH . 'admin/templates/loginform.php';
        } elseif (!empty($_SESSION['kickstart_login']) && $_SESSION['kickstart_login']) {
            header('Location: ' . $this->base->url . '/admin/posts');
            exit();
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $error = $this->validateDetails();
            } elseif (!empty($_GET['status']) && $_GET['status'] == 'inactive') {
                session_unset();
                session_destroy();
                $error = 'Сеанс завершён в связи с отсутствием активности. Пожалуйста, авторизуйтесь снова.';
            }
            require_once APP_PATH . 'admin/templates/loginform.php';      
        }
    }
    public function loginSuccess() {
        $_SESSION['kickstart_login'] = true;
        $_SESSION['timeout'] = time();
        header('Location: ' . $this->base->url . '/admin/posts');
        return;
    }
    public function loginFail() {
        return 'Неверное имя пользователя/пароль';
    }
    private function validateDetails() {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {          
            $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
            $password = crypt($_POST['password'], $salt);
            $return = $this->ksdb->dbselect('users', array('*'), 
			    array('name' => $_POST['username'], 'password' => $password));

            if (!empty($return) && !empty($return[0])) {
                $this->loginSuccess();
            } else {
                return $this->loginFail();
            }
        }
    }
}
