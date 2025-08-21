<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<form action="<?php echo $this->base->url.'/admin/posts.php?action=save'; ?>" method="POST">
    <?php foreach($posts as $post): ?>
	<h3>Редактирование сообщения №<?php echo htmlspecialchars($post['id']); ?></h3>
	<input type="hidden" name="post[id]" value="<?php echo htmlspecialchars($post['id']); ?>" />
	<label for="title">Заголовок</label><br>
	<input type="text" name="post[title]" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" /><br>
	<label for="content">Сообщение</label><br>
	<textarea name="post[content]" id="content"><?php echo htmlspecialchars($post['content']); ?></textarea><br>
	<?php endforeach; ?>
	<button type="submit">Сохранить сообщение</button>
</form>
<?php
require_once ('_inc/footer.php');
