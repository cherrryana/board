<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
    'LIST' => array(
        'CONT' => 'bx_sitemap',
        'TITLE' => 'bx_sitemap_title',
        'LIST' => 'bx_sitemap_ul',
    ),
    'LINE' => array(
        'CONT' => 'bx_catalog_line',
        'TITLE' => 'bx_catalog_line_category_title',
        'LIST' => 'bx_catalog_line_ul',
        'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
    ),
    'TEXT' => array(
        'CONT' => 'bx_catalog_text',
        'TITLE' => 'bx_catalog_text_category_title',
        'LIST' => 'bx_catalog_text_ul'
    ),
    'TILE' => array(
        'CONT' => 'bx_catalog_tile',
        'TITLE' => 'bx_catalog_tile_category_title',
        'LIST' => 'bx_catalog_tile_ul',
        'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
    )
);
$userLogin = \Bitrix\Main\Engine\CurrentUser::get()->getLogin();
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];
$currentTeam = ScrumBoard\Helper::GetUserTeam($USER->GetID());

$teamName = ScrumBoard\Helper::GetTeamName($currentTeam);
$teamMembers = ScrumBoard\Helper::GetTeamMembers($currentTeam);
$memberNames = ScrumBoard\Helper::GetUserNames($teamMembers);
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
$membersAmount = count($memberNames);
?>



<div class="main-menu__inner">
    <ul class="main-menu__site-nav site-nav">
        <li class="site-nav__item">
            <a class="site-nav__link site-nav__link--home" href="index.php">Главная</a>
        </li>
    </ul>
    <div class="main-menu__board-nav board-nav">
        <span class="board-nav__title">Доски вашей команды</span>
        <ul class="board-nav__list">
            <?php foreach ($arResult['SECTIONS'] as $key => $section):?>
                <li class="board-nav__item">
                    <a class="board-nav__link" href="http://board.lynx-digital.ru/?board=<?=$section['ID']?>"><?=$section['NAME']?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="main-menu__popover popover">
        <section class="popover__content team-menu">
            <h2 class="team-menu__name"><?=$teamName?></h2>
            <ul class="team-members-list">
                <?foreach ($memberNames as $name):?>
                <li class="team-member-info">
                    <div class="team-member-info__avatar">
                        <?=substr($name,0,1)?>
                    </div>
                    <span class="team-member-info__name"><?=$name?></span>
                </li>
                <?endforeach;?>
            </ul>
            <ul class="team-menu__links-list">
                <li class="team-menu__links-item">
                    <a class="team-menu__link team-menu__link--new-member popup-toggle-open new-member-toggle" href="#">Добавить участника</a>
                </li>
            </ul>
            <button class="arrow-toggle team-menu__button team-menu-toggle" type="button"><span class="visually-hidden">Закрыть панель</span></button>
        </section>
    </div>
    <?if($teamName):?>
        <section class="main-menu__team-info team-info team-menu-toggle">
            <h2 class="team-info__name"><?=$teamName?></h2>
            <div class="team-info__avatar"><?=substr($teamName,0,1)?></div>
            <span class="team-info__members">
                <span class="team-info__members-count"><?=$membersAmount?></span>
                <?echo ScrumBoard\Helper::declination($membersAmount,array('Пользователь','Пользователя','Пользователей'))?>
            </span>
            <span class="arrow-toggle team-info__toggle">
                <span class="visually-hidden">Информация о команде</span>
            </span>
        </section>
    <?endif?>
</div>

