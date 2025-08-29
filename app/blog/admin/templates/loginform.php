<?php require_once '_inc/header.php' ?>
<br>

<div class="login-container">
<div class="login-card">
            <div class="login-header">
                <h2><i class="bi bi-shield-lock me-2"></i>Админ-панель</h2>
                <p class="mb-0">Войдите для управления контентом</p>
            </div>
<div class="login-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form id="loginForm" action="/login" method="post">
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Имя пользователя</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Введите имя пользователя" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Введите пароль" required>
                            <span class="input-group-text password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    
                    <!--div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Запомнить меня</label>
                    </div-->
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-login btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Войти
                        </button>
                    </div>
                </form>
    </div>
</div>
</div>
<?php require_once '_inc/footer.php' ?>
