<?php
// Принудительно переопределяем SERVER_NAME, если задан в окружении
if (isset($_ENV['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_ENV['SERVER_NAME'];
}
require_once('database.php');
class Login {
    public function __construct() {
        $this->ksdb = new Database;
        $this->base = (object) '';
        $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];
        $this->index();
    }
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error = $this->validateDetails();
        } elseif (!empty($_GET['status']) && $_GET['status'] == 'inactive') {
            $error = 'Сеанс завершён в связи с отсутствием активности. Пожалуйста, авторизуйтесь снова.';
        }
        require_once 'admin/templates/loginform.php';
    }
    public function loginSuccess() {
        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/admin/posts.php');
        return;
    }
    public function loginFail() {
        return 'Неверное имя пользователя/пароль';
    }
    private function validateDetails() {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {          
            $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
            $password = crypt($_POST['password'], $salt);
            $return = array();
            $query = $this->ksdb->db->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
            try {
                $query->execute(array($_POST['username'], $password));
                for ($i = 0; $row = $query->fetch(); $i++) {
                    $return[$i] = array();
                    foreach ($row as $key => $rowitem) {
                        $return[$i][$key] = $rowitem;
                    }
                }               
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            if (!empty($return) && !empty($return[0])) {
                $this->loginSuccess();
            } else {
                return $this->loginFail();
            }
        }
    }
}
