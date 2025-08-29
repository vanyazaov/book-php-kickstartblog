<?php require_once('_inc/header.php'); ?>
<br>
<!-- Кнопка возврата -->
<div class="row mb-4">
    <a href="<?php echo $this->base->url; ?>" class="back-link d-inline-flex align-items-center text-primary fw-bold">
        <i class="bi bi-arrow-left me-2"></i> Назад к списку постов
    </a>
</div>
<?php foreach($posts as $post): ?>
        <!-- Пост -->
                <article class="card shadow-sm">
                    <div class="card-body p-5">
                        <h1 class="card-title mb-3"><?php echo (!empty($post['title']) ? htmlspecialchars($post['title']) : 'Сообщение №' . htmlspecialchars($post['id'])); ?></h1>
                        <div class="post-meta d-flex align-items-center mb-4 text-muted">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-chat-dots me-2"></i>
                                <span>Комментарии: <?php echo count($postcomments); ?></span>
                            </div>
                        </div>
                        
                        <div class="post-content">
                            <?php echo $post['content']; ?>
                        </div>
                    </div>
                </article>
<?php endforeach; ?>
<div class="row mt-4">
    <!-- Комментарии -->
    <div class="d-flex align-items-center mb-4">
        <h2 class="mb-0">Комментарии</h2>
        <span class="badge bg-primary ms-3"><?php echo count($postcomments); ?></span>
    </div>
</div>
<?php foreach($postcomments as $comment): ?>
    <!-- Комментарий -->
    <div class="card comment mb-3">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <img src="http://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>" alt="Аватар" class="comment-avatar">
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="mb-0 me-2"><?php echo htmlspecialchars($comment['name']); ?></h5>
                    </div>
                    <p class="mb-0"><?php echo htmlspecialchars($comment['comment']); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- Форма добавления комментария -->
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h3 class="card-title mb-4">Добавить комментарий</h3>
        <?php if (isset($_GET['savecomment']) && $_GET['savecomment'] === 'error'): ?>
            <div class="alert alert-danger mb-3" role="alert">
                В процессе сохранения вашего комментария возникла ошибка. Пожалуйста, повторите попытку позднее.
            </div>
        <?php elseif (isset($_GET['savecomment']) && $_GET['savecomment'] === 'success'): ?>
            <div class="alert alert-success mb-3" role="alert">
                Ваш комментарий успешно сохранен.
            </div>
        <?php endif; ?>
        <form action="/" method="post">
            <input type="hidden" name="comment[postid]" value="<?php echo $_GET['id'];?>" />
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control" id="name" name="comment[fullname]" placeholder="Ваше полное имя">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="comment[email]" id="email" placeholder="Адрес электронной почты">
                </div>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Комментарий</label>
                <textarea class="form-control" rows="4" id="comment" name="comment[context]"></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary px-4">Отправить комментарий</button>
            </div>
        </form>
    </div>
</div>

<?php require_once '_inc/footer.php'; ?>
