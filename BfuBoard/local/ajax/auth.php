<?php require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('socialnetwork');


global $USER;
if (!is_object($USER)) $USER = new CUser;
$success = false;
$password = $_POST['user-password'];
$login = $_POST['user-login'];
if(!empty($_POST) && $_POST['user-login'] != 'admin'){

    $arAuthResult = $USER->Login(strval($login), strval($password), "Y","Y");
    $APPLICATION->arAuthResult = $arAuthResult;
}
echo json_encode(array($password,$login));
