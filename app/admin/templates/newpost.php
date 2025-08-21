<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<form action="<?php echo $this->base->url.'/admin/posts.php?action=save'; ?>" method="POST">
	<h3>Новое сообщение</h3>
	<label for="title">Заголовок</label><br>
	<input type="text" name="post[title]" id="title" placeholder="Заголовок вашего сообщения" /><br>
	<label for="wmd-input">Сообщение</label><br>
	<div class="wmd-panel">
            <div id="wmd-button-bar"></div>
            <textarea class="wmd-input" id="wmd-input" name="post[content]"></textarea>
    </div>
    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
	<button type="submit">Сохранить сообщение</button>
</form>
<?php
require_once ('_inc/footer.php');
