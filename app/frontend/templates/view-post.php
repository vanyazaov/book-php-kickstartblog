<?php require_once('_inc/header.php'); ?>
<br>
<a href="<?php echo $this->base->url; ?>">Вернуться к списку сообщений</a>
<?php foreach($posts as $post): ?>
<h3><?php echo (!empty($post['title']) ? htmlspecialchars($post['title']) : 'Сообщение №' . htmlspecialchars($post['id'])); ?></h3>
<p><?php echo $post['content']; ?></p>
<?php endforeach; ?>
<h3>Комментарии</h3>
<?php foreach($postcomments as $comment): ?>
<p>
    <img src="http://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>" alt=""/>
    <strong><?php echo htmlspecialchars($comment['name']); ?></strong><br>
    <em><?php echo htmlspecialchars($comment['comment']); ?></em>
</p>
<?php endforeach; ?>
<h4>Оставьте комментарий</h4>
<?php if (isset($_GET['savecomment']) && $_GET['savecomment'] === 'error'): ?>
    <p style="color:red;">В процессе сохранения вашего комментария возникла ошибка. Пожалуйста, повторите попытку позднее.</p>
<?php elseif (isset($_GET['savecomment']) && $_GET['savecomment'] === 'success'): ?>
    <p style="color:green;">Ваш комментарий успешно сохранен.</p>
<?php endif; ?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="hidden" name="comment[postid]" value="<?php echo $_GET['id'];?>" />
    <div><?php echo (!empty($error) ? $error: ''); ?></div>
    <label for="email">Email</label><br>
    <input type="email" name="comment[email]" id="email" placeholder="Адрес электронной почты" /><br>
    <label for="name">Full name</label><br>
    <input type="text" name="comment[fullname]" id="name" placeholder="Ваше полное имя" /><br>
    <label for="comment">Комментарий</label><br>
    <textarea id="comment" name="comment[context]"></textarea><br>
    <button type="submit">Отправить комментарий</button>
</form>
<?php require_once '_inc/footer.php'; ?>
