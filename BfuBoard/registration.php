<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>
<link rel="stylesheet" href="misc/style.css">
<body class="page__body">
<main class="page__main">
    <div class="content-wrapper">
        <a class="logoicon" href="#">
            <img class="icon" src="/local/templates/board/images/logo.svg" width="295" height="80" alt="Логотип 'MyBoard'.">
        </a>
        <div class="form-wrapper registration-form active">
            <h1 class="form-title">Регистрация</h1>
            <form name="registration" class="form-container" method="post" action="local/ajax/reg.php">
                <div class="form-fields">
                    <label for="user-email" class="form-text">Ваш email:</label>
                    <div class="form-field">
                        <input type="email" class="colortxt" id="user-email" name="user-email"  placeholder="Введите ваш email" required>
                    </div>
                    <label for="user-login" class="form-text">Логин:</label>
                    <div class="form-field">
                        <input type="text" class="colortxt" id="user-login" name="user-login" placeholder="Введите ваш логин" required>
                    </div>
                    <label for="user-password" class="form-text">Пароль:</label>
                    <div class="form-field">
                        <input type="password" class="colortxt" id="user-password" name="user-password" placeholder="Введите ваш пароль" required>
                    </div>
                    <button class="button submit-button" type="submit">Регистрация</button>
                </div>
            </form>
            <div class="divider">Есть аккаунт? <a href="authorization.php" class="link">Войти</a></div>
        </div>
    </div>
    <script src="script.js"></script>
</main>
</body>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        let links = document.querySelectorAll('.link');
        let registrationForm = document.querySelector("form[name='registration']");
        links.forEach((link) => {
            link.addEventListener('click', (evt) => {
                evt.preventDefault();
                registrationForm.classList.toggle('active');
            })
        })
        function customFormSubmit(form){
            let formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            setTimeout(function () {
                location.href = 'http://board.lynx-digital.ru/'
            },200)

        }
        registrationForm.addEventListener('submit',function(e){
            e.preventDefault()
            customFormSubmit(registrationForm)

        })

    })
</script>
