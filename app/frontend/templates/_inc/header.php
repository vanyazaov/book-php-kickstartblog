<?php header("Content-Type: text/html;charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой блог</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/includes/css/app.css" rel="stylesheet">
</head>
<body>
    <!-- Верхнее меню -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">Мой блог</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Главная</a>
                    </li>
                    <?php if (!empty($_SESSION['kickstart_login']) && $_SESSION['kickstart_login']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Админ-панель</a>
                    </li>
                    <?php else: ?>                   
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Вход в админку</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="content">
        <?php if(!isset($_GET['id'])): ?>
        <!-- Приветственный текст -->
        <section class="welcome-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 class="display-6">Добро пожаловать в мой блог!</h1>
                        <p class="lead">Здесь я делюсь своими мыслями, идеями и опытом. Читайте, комментируйте и присоединяйтесь к обсуждению!</p>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Контент блога -->
        <div class="container mb-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
