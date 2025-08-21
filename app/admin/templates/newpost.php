<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<form action="<?php echo $this->base->url.'/admin/posts.php?action=save'; ?>" method="POST">
	<h3>Новое сообщение</h3>
	<label for="title">Заголовок</label><br>
	<input type="text" name="post[title]" id="title" placeholder="Заголовок вашего сообщения" /><br>
	<label for="content">Сообщение</label><br>
	<textarea name="post[content]" id="content"></textarea><br>
	<button type="submit">Сохранить сообщение</button>
</form>
<?php
require_once ('_inc/footer.php');
