<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<a href="<?php echo $this->base->url;?>/admin/posts.php?action=create">Создать сообщение</a> | 
<a href="<?php echo $this->base->url;?>/admin/comments.php">Комментарии</a>
<table>
    <thead>
        <tr>
            <th>Заголовок</th>
            <th>Содержимое</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post): ?>
        <tr>
            <th><?php echo (!empty($post['title']) ? htmlspecialchars($post['title']) : 'Сообщение №' . htmlspecialchars($post['id'])); ?></th>
            <td><p><?php echo implode(' ', array_slice(explode(' ',strip_tags($post['content'])), 0, 10)); ?> [...]</p></td>
            <td><a href="<?php echo $this->base->url . "/admin/posts.php?id=".$post['id']."&action=edit"?>">Править</a> | <a href="<?php echo $this->base->url . "/admin/posts.php?id=".$post['id']."&action=delete"?>">Удалить</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
require_once ('_inc/footer.php');
