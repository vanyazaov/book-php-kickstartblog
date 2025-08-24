<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<!-- Заголовок и кнопка создания -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="admin-header">
        <h1 class="h3 mb-1">Управление комментариями</h1>
        <p class="mb-0">Просмотр и удаление комментариев к записям блога</p>
    </div>
</div>
<!-- Таблица постов -->
<div class="card admin-table">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" width="25%">Автор комментария</th>
                        <th scope="col" width="25%">Идентификатор сообщения</th>
                        <th scope="col" width="25%">Комментарий</th>
                        <th scope="col" width="25%">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td class="fw-bold"><?php echo htmlspecialchars($comment['name']); ?></th>
                        <td class="fw-bold"><?php echo htmlspecialchars($comment['email']); ?></th>
                        <td class="content-preview"><p><?php echo strip_tags($comment['comment']); ?></p></td>
                        <td><a class="btn btn-sm btn-delete" href="<?php echo $this->base->url . "/admin/comments.php?id=".htmlspecialchars($comment['id'])."&action=delete"?>" onclick="return confirm('Вы хотите удалить?')">Удалить комментарий</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require_once ('_inc/footer.php');
