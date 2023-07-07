<?php require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
    \Bitrix\Main\Loader::includeModule('socialnetwork');

    global $USER;

    $login = $_POST['user-login'];

    $email = $_POST['user-email'];

    $password = $_POST['user-password'];

    $arResult = $USER->Register($login, "", "", $password, $password, $email);

    header("Location: http://board.lynx-digital.ru/");
    exit( );


