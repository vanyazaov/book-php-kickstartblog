<?php header("Content-Type: text/html;charset=utf-8");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>Админ-панель: My Blog</title>
<link rel="stylesheet" type="text/css" href="/includes/css/markdown.css" />
<script type="text/javascript" src="/includes/js/Markdown.Converter.js"></script>
<script type="text/javascript" src="/includes/js/Markdown.Sanitizer.js"></script>
<script type="text/javascript" src="/includes/js/Markdown.Editor.js"></script>
</head>
<body>
<a href="/">Главная</a> | <a href="/admin/posts.php">Админ-панель</a>
<hr>
<h1>Welcome to my blog's admin panel!</h1>
<?php
    if (!empty($_GET['delete']) && $_GET['delete'] == 'error') { 
        echo '<p style="color: red">Удаление завершилось ошибкой.</p>';     
    }
    if (!empty($_GET['delete']) && $_GET['delete'] == 'success') { 
        echo '<p style="color: green">Пост удалён.</p>';     
    }
    
    if (!empty($_GET['save']) && $_GET['save'] == 'error') { 
        echo '<p style="color: red">В процессе сохранения вашего сообщения возникла ошибка. Пожалуйста, повторите попытку позднее.</p>';     
    }
    if (!empty($_GET['save']) && $_GET['save'] == 'success') { 
        echo '<p style="color: green">Ваше сообщение успешно сохранено.</p>';     
    } 
    if (!empty($_GET['edit']) && $_GET['edit'] == 'notfound') { 
        echo '<p style="color: red">Пост не найден.</p>';     
    }
?>
