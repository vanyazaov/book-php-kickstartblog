</div>
<!-- Футер -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; Мой блог, <?php echo date('Y'); ?>. Все права защищены.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    (function () {
                var converter1 = Markdown.getSanitizingConverter();
                
                converter1.hooks.chain("preBlockGamut", function (text, rbg) {
                    return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
                        return "<blockquote>" + rbg(inner) + "</blockquote>\n";
                    });
                });
                
                var editor1 = new Markdown.Editor(converter1);
                
                editor1.run();
                
                
                
                var help = function () { alert("Do you need help?"); }
                var options = {
                    helpButton: { handler: help },
                    strings: { quoteexample: "whatever you're quoting, put it right here" }
                };
            })();
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Переключение видимости пароля
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('inputPassword');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Изменение иконки
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
            
            // Валидация формы
            const loginForm = document.getElementById('loginForm');
            
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const username = document.getElementById('inputEmail').value;
                const password = document.getElementById('inputPassword').value;
                
                // Простая валидация
                if (username.trim() === '') {
                    showError('Пожалуйста, введите имя пользователя');
                    return;
                }
                
                if (password.length < 4) {
                    showError('Пароль должен содержать не менее 4 символов');
                    return;
                }
                
                // Имитация успешного входа
                simulateLogin();
            });
            
            function showError(message) {
                // Удаляем предыдущие сообщения об ошибках
                const existingAlert = document.querySelector('.alert');
                if (existingAlert) {
                    existingAlert.remove();
                }
                
                // Создаем сообщение об ошибке
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>${message}`;
                
                // Вставляем сообщение перед формой
                loginForm.parentNode.insertBefore(alertDiv, loginForm.nextSibling);
                
                // Автоматическое скрытие через 5 секунд
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            }
            
            function simulateLogin() {
                const loginBtn = loginForm.querySelector('button[type="submit"]');
                const originalText = loginBtn.innerHTML;
                
                // Показываем индикатор загрузки
                loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Выполняется вход...';
                loginBtn.disabled = true;
                
                // Имитация задержки сервера
                setTimeout(() => {
                   loginForm.submit();                  
                }, 1000);
            }
        });
    </script>
</body>
</html>
