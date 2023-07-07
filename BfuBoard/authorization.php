<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
?>

<link rel="stylesheet" href="misc/style.css">
<body class="page__body">
<main class="page__main">
    <div class="content-wrapper">
        <a class="logoicon" href="#">
            <img class="icon" src="/local/templates/board/images/logo.svg" width="295" height="80" alt="Логотип 'MyBoard'.">
        </a>
        <div class="form-wrapper active">
            <h1 class="form-title">Вход</h1>
            <form name="auth" class="form-container" method="post" action="local/ajax/auth.php">
                <div class="form-fields">
                    <label for="user-email" class="form-text">Ваш логин:</label>
                    <div class="form-field">
                        <input type="text" class="colortxt" id="user-login" name="user-login"  placeholder="Введите ваш логин" required>
                    </div>
                    <label for="user-password" class="form-text">Пароль:</label>
                    <div class="form-field">
                        <input type="password" class="colortxt" id="user-password" name="user-password" placeholder="Введите ваш пароль" required>
                    </div>
                    <button class="button submit-button" type="submit">Войти</button>
                </div>
            </form>
            <div class="divider">Нет аккаунта? <a href="registration.php" class="link registration-button">Зарегистрироваться</a></div>
        </div>
    </div>
</main>
</body>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        let links = document.querySelectorAll('.link');
        let logInForm = document.querySelector("form[name='auth']");
        links.forEach((link) => {
            link.addEventListener('click', (evt) => {
                logInForm.classList.toggle('active');
            })
        })


        async function customFormSubmit(form){
            let formData = new FormData(form);
            let response = await fetch(form.action, {
                method: 'POST',
                body: formData
            })

            if (response.ok) {
                let json = await response.json();
                console.log(json)
            } else {
                alert("Ошибка HTTP: " + response.status);
            }

            location.href = 'http://board.lynx-digital.ru/'
        }


        logInForm.addEventListener('submit',function(e){
            e.preventDefault()
            customFormSubmit(logInForm)
        })

    })
</script>
