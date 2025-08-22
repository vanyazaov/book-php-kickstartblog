<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<a href="<?php echo $this->base->url;?>/admin/posts.php">Сообщения</a>
<table>
    <thead>
        <tr>
            <th>Автор комментария</th>
            <th>Идентификатор сообщения</th>
            <th>Комментарий</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comments as $comment): ?>
        <tr>
            <th><?php echo htmlspecialchars($comment['name']); ?></th>
            <th><?php echo htmlspecialchars($comment['email']); ?></th>
            <td><p><?php echo strip_tags($comment['comment']); ?></p></td>
            <td><a href="<?php echo $this->base->url . "/admin/comments.php?id=".htmlspecialchars($comment['id'])."&action=delete"?>">Удалить комментарий</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
require_once ('_inc/footer.php');
