<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<html>
<head>


<?$APPLICATION->ShowHead();?>
<title><?$APPLICATION->ShowTitle()?></title>
	<link rel="stylesheet" href="css/style.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<?
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}
if($_GET['logout'] == 'Y'){
    $USER->Logout();
}

$currentTeam = ScrumBoard\Helper::GetUserTeam($USER->GetID());
$IsTeamLeader = ScrumBoard\Helper::IsTeamLeader($currentTeam,$USER->GetID());
$allowedTeamBoards = ScrumBoard\Helper::GetTeamBoards($currentTeam);
$currentBoard = $_GET['board'];
$userLogin = \Bitrix\Main\Engine\CurrentUser::get()->getLogin();
if(!$currentBoard){
    $currentBoard = array_key_first($allowedTeamBoards);
};
$boardName = ScrumBoard\Helper::GetBoardName($currentBoard);
if(!$currentTeam){
    $boardName = "";
}
$teamName = ScrumBoard\Helper::GetTeamName($currentTeam);
$APPLICATION->ShowPanel()?>


<?php if($USER->IsAuthorized()):?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<header class="header">
		<div class="header__inner">
			<div class="header__left">
				<a class="header__logo" href="index.php">
					<img src="/local/templates/board/images/logo.svg" width="126" height="36" alt="Логотип 'MyBoard'.">
				</a>
				<nav class="header__nav main-menu">
					<button class="main-menu__toggle" type="button"><span class="visually-hidden">Открыть меню</span></button>
                    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","board_list",
                        Array(
                            "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                            "VIEW_MODE" => "TEXT",
                            "SHOW_PARENT_NAME" => "Y",
                            "IBLOCK_TYPE" => "",
                            "IBLOCK_ID" => "1",
                            "SECTION_ID" => $_REQUEST["SECTION_ID"],
                            "SECTION_CODE" => "",
                            "SECTION_FIELDS" => "",
                            "SECTION_USER_FIELDS" =>
                                array(
                                      0 => 'UF_TEAM'
                                 ),
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "Y",
                            "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                            "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
                            "TOP_DEPTH" => "1",
                            "SECTION_FIELDS" => "",
                            "SECTION_USER_FIELDS" => "",
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_NOTES" => "",
                            "CACHE_GROUPS" => "Y"
                        )
                    );?>
				</nav>
			</div>


            <div class="header__center">
                <h1 class="page__title"><?=$boardName?></h1>
                <?php if($IsTeamLeader):?>
                <button class="popup-toggle-open new-board-toggle" type="button">
                    <span class="visually-hidden">Создать новую доску</span>
                </button>
                <?php endif ?>
            </div>

            <div class="header__right header-right-menu">
                <div class="header-right-menu__item">
                    <button class="header-right-menu__notification-toggle" type="button">
                        <span class="visually-hidden">Уведомления</span>
                    </button>
                </div>
                <div class="header-right-menu__item">
                    <a class="user-info" href="#">
                        <div class="user-info__avatar"><?=$userLogin[0]?></div>
                        <span class="user-info__name"><?=$userLogin?></span>
                        <span class="user-info__toggle arrow-toggle"></span>
                    </a>
                    <div class="header-right-menu__popover popover">
                        <ul class="popover__content user-menu">
                            <li class="user-menu__item">
                                <a class="user-menu__link user-menu__link--log-out" href="/?logout=Y">Выйти из аккаунта</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
		</div>
	</header>
<?php
endif?>

