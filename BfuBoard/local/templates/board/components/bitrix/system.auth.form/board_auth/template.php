<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();
?>


<div class="bx-system-auth-form">

<?
var_dump($arParams['REGISTER_URL']);
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>
<?var_dump($arResult["FORM_TYPE"] )?>
    <div class="content-wrapper">
        <a class="logoicon" href="login.html">
            <img class="icon" src="images/logo.svg" width="295" height="80" alt="Логотип 'MyBoard'.">
        </a>
<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
    <?if($arResult["BACKURL"] <> ''):?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <?endif?>
    <?foreach ($arResult["POST"] as $key => $value):?>
        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
    <?endforeach?>
        <div class="form-wrapper active">
            <h1 class="form-title">Вход</h1>
                <div class="form-fields">
                    <label for="user-email" class="form-text">Ваш email:</label>
                    <div class="form-field">
                        <input type="text" class="colortxt" id="user-name" name="USER_LOGIN" maxlength="50" value="" size="17" placeholder="Введите ваш логин" required>
                    </div>
                    <label for="user-password" class="form-text">Пароль:</label>
                    <div class="form-field">
                        <input type="password" name="USER_PASSWORD" maxlength="255" size="17" autocomplete="off" class="colortxt" id="user-password" placeholder="Введите ваш пароль" required>
                    </div>
                    <button name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" class="button submit-button" type="submit">Войти</button>
                </div>
            <div class="divider">Нет аккаунта? <a href="<?=$arParams['REGISTER_URL']?>" class="link registration-button">Зарегистрироваться</a></div>
        </div>
    </div>

	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
			<script>
				BX.ready(function() {
					var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
					if (loginCookie)
					{
						var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
						var loginInput = form.elements["USER_LOGIN"];
						loginInput.value = loginCookie;
					}
				});
			</script>

</form>
</div>
