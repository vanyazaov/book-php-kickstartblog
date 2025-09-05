<?php require_once('_inc/header.php'); ?>
<?php foreach($posts as $post): ?>
<!-- Пост -->
<article class="card mb-4">
    <div class="card-body">
        <h2 class="card-title"><?php echo (!empty($post['title'])) ? e($post['title']) : 'Сообщение № ' . e($post['id']); ?></h2>
        <p class="card-text"><?php echo implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)) ?> [...]</p>
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo $this->base->url . "/?id=" .$post['id']; ?>" class="btn btn-primary">Читать далее</a>
            <span class="badge bg-secondary">Комментарии: <?php echo $post['comments']; ?></span>
        </div>
    </div>
</article>
<?php endforeach; ?>
<?php require_once('_inc/footer.php'); ?>
