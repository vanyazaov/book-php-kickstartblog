<?php header('Content-Type: text/html;charset=utf-8'); 
require_once ('_inc/header.php');
?>
<!-- Основной контент -->
<div class="editor-container">
    <div class="row">
        <div class="col-12">
            <div class="editor-card">
            <form action="<?php echo $this->base->url.'/admin/posts?action=save'; ?>" method="POST">
             <?php foreach($posts as $post): ?>
                <input type="hidden" name="post[id]" value="<?php echo e($post['id']); ?>" />
                <div class="editor-header">
                    <h2><i class="bi bi-pencil-square me-2"></i>Редактор поста</h2>
                    <p class="mb-0">Редактирование сообщения №<?php echo e($post['id']); ?></p>
                </div>
                
                <div class="editor-body">                  
                    <!-- Заголовок поста -->
                    <div class="mb-4">
                        <label for="postTitle" class="form-label">Заголовок поста</label>
                        <input type="text"  name="post[title]" class="form-control form-control-lg" id="postTitle" placeholder="Введите заголовок поста" value="<?php echo e($post['title']); ?>">
                    </div>
                    
                    <div class="row">
                        <!-- Редактор -->
                        <div class="col-lg-6 mb-4 wmd-panel">
                            <label class="form-label">Сообщение</label>
                            <!-- Панель форматирования -->
                            <div class="formatting-toolbar mb-2" id="wmd-button-bar"></div>                            
                            <textarea class="form-control editor-textarea wmd-input" id="wmd-input" name="post[content]" placeholder="Начните писать свой пост здесь..."><?php echo e($post['content']); ?></textarea>
                        </div>
                        
                        <!-- Предпросмотр -->
                        <div class="col-lg-6 mb-4" >
                            <label class="form-label">Предпросмотр</label>
                            <div class="preview-area wmd-panel wmd-preview" id="wmd-preview">
                                <!-- Предпросмотр будет генерироваться здесь -->
                            </div>
                        </div>
                    </div>
                    
               <?php endforeach; ?>     
                    <!-- Кнопки действия -->
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-save btn-lg">
                            <i class="bi bi-check-circle me-1"></i>Сохранить сообщение
                        </button>
                    </div>
                </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once ('_inc/footer.php');
