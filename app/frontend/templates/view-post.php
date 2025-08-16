<?php header("Content-Type: text/html;charset=utf-8"); ?>
<meta http-equiv="Content-Type" content="text/html"/>
<?php require_once('includes/temps/header.php'); ?>
<br>
<a href="<?php echo $this->base->url; ?>">Вернуться к списку сообщений</a>
<?php foreach($posts as $post): ?>
<h3>Сообщение №<?php echo htmlspecialchars($post['id']); ?></h3>
<p><?php echo htmlspecialchars($post['content']); ?></p>
<?php endforeach; ?>
<?php require_once 'includes/temps/footer.php'; ?>
