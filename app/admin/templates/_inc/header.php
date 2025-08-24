<?php header("Content-Type: text/html;charset=utf-8");?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель: Мой блог</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/includes/css/adminpanel.css">
    <link rel="stylesheet" href="/includes/css/markdown.css" />
    <script type="text/javascript" src="/includes/js/Markdown.Converter.js"></script>
    <script type="text/javascript" src="/includes/js/Markdown.Sanitizer.js"></script>
    <script type="text/javascript" src="/includes/js/Markdown.Editor.js"></script>
</head>
<body>
    <!-- Фиксированное верхнее меню для админ-панели -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand admin-brand" href="/admin/posts.php">
                <i class="bi bi-speedometer2 me-2"></i>Админ-панель
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house-door me-1"></i> На сайт</a>
                    </li>
                    <?php if (!empty($_SESSION['kickstart_login']) && $_SESSION['kickstart_login']): ?>
                    <li class="nav-item">
                        <a class="nav-link <? echo $_SERVER['SCRIPT_NAME'] === '/admin/posts.php' ? 'active' : '' ?>" href="/admin/posts.php"><i class="bi bi-file-post me-1"></i> Посты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <? echo $_SERVER['SCRIPT_NAME'] === '/admin/comments.php' ? 'active' : '' ?>" href="/admin/comments.php"><i class="bi bi-chat-dots me-1"></i> Комментарии</a>
                    </li>                  
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php?status=logout"><i class="bi bi-box-arrow-right me-1"></i> Выйти</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Контент админ-панели -->
    <div class="container mt-4">
<?php
    if (!empty($_GET['delete']) && $_GET['delete'] == 'error') {  
        echo '<div class="alert alert-danger mb-3" role="alert">
            Удаление завершилось ошибкой.
        </div>'; 
    }
    if (!empty($_GET['delete']) && $_GET['delete'] == 'success') {  
        echo '<div class="alert alert-success mb-3" role="alert">
            Пост удалён.
        </div>';     
    }
    
    if (!empty($_GET['save']) && $_GET['save'] == 'error') { 
        echo '<div class="alert alert-danger mb-3" role="alert">
            В процессе сохранения вашего сообщения возникла ошибка. Пожалуйста, повторите попытку позднее.
        </div>';   
    }
    if (!empty($_GET['save']) && $_GET['save'] == 'success') {    
        echo '<div class="alert alert-success mb-3" role="alert">
            Ваше сообщение успешно сохранено.
        </div>'; 
    } 
    if (!empty($_GET['edit']) && $_GET['edit'] == 'notfound') { 
        echo '<div class="alert alert-danger mb-3" role="alert">
            Пост не найден.
        </div>';      
    }
?>
