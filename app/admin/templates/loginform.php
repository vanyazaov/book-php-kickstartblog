<?php require_once 'frontend/templates/_inc/header.php' ?>
<br>
<?php if (!empty($error)): ?>
    <div style="color: red;">~<?php echo $error; ?></div>
<?php endif; ?>
<br>
<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <h3>Вход в админ-панель</h3>
    <label for="inputEmail">Имя пользователя</label>
    <input type="text" name="username" id="inputEmail" placeholder="Имя пользователя" />
    <label for="inputPassword">Пароль</label>
    <input type="password" name="password" id="inputPassword" placeholder="Пароль" />
    <button type="submit">Войти</button>
</form>

<?php require_once 'frontend/templates/_inc/footer.php' ?>
