<?php require_once('_inc/header.php'); ?>
<br>
<a href="<?php echo $this->base->url; ?>">Вернуться к списку сообщений</a>
<?php foreach($posts as $post): ?>
<h3><?php echo (!empty($post['title']) ? htmlspecialchars($post['title']) : 'Сообщение №' . htmlspecialchars($post['id'])); ?></h3>
<p><?php echo htmlspecialchars($post['content']); ?></p>
<?php endforeach; ?>
<?php require_once '_inc/footer.php'; ?>
