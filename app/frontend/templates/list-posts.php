<?php require_once('_inc/header.php'); ?>
<?php foreach($posts as $post): ?>
<h3><?php echo (!empty($post['title'])) ? htmlspecialchars($post['title']) : 'Сообщение № ' . htmlspecialchars($post['id']); ?></h3>
<p><?php echo implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)) ?> [...]</p>
<a href="<?php echo $this->base->url . "/?id=" .$post['id']; ?>">Подробнее</a>
<?php endforeach; ?>
<hr/>
<?php require_once('_inc/footer.php'); ?>
