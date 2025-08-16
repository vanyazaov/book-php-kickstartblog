<?php header("Content-Type: text/html;charset=utf-8"); ?>
<meta http-equiv="Content-Type" content="text/html"/>
<?php require_once('includes/temps/header.php'); ?>
<?php foreach($posts as $post): ?>
<h3>Сообщение №<?php echo $post['id']; ?></h3>
<p><?php echo implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)) ?> [...]</p>
<a href="<?php echo $this->base->url . "/?id=" .$post['id']; ?>">Подробнее</a>
<?php endforeach; ?>
<hr/>
<?php require_once('includes/temps/footer.php'); ?>
