<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<h1>Добро пожаловать в админ-панель блога!</h1>
<!-- Заголовок и кнопка создания -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="admin-header">
        <h1 class="h3 mb-1">Управление постами</h1>
        <p class="mb-0">Создание, редактирование и удаление записей блога</p>
    </div>
    <a class="btn btn-admin" href="<?php echo $this->base->url;?>/admin/posts.php?action=create">
        <i class="bi bi-plus-circle me-2"></i>Создать пост
    </a>
</div>
        <!-- Таблица постов -->
        <div class="card admin-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="35%">Заголовок</th>
                                <th scope="col" width="45%">Содержимое</th>
                                <th scope="col" width="20%">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($posts as $post): ?>
                            <!-- Пост 1 -->
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo (!empty($post['title']) ? htmlspecialchars($post['title']) : 'Сообщение №' . htmlspecialchars($post['id'])); ?></div>
                                </td>
                                <td>
                                    <div class="content-preview">
                                        <?php echo implode(' ', array_slice(explode(' ',strip_tags($post['content'])), 0, 10)); ?> [...]
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-edit" href="<?php echo $this->base->url . "/admin/posts.php?id=".$post['id']."&action=edit"?>">
                                            Править
                                        </a>
                                        <a class="btn btn-sm btn-delete" href="<?php echo $this->base->url . "/admin/posts.php?id=".$post['id']."&action=delete"?>" onclick="return confirm('Вы хотите удалить?')">
                                            Удалить
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
require_once ('_inc/footer.php');
