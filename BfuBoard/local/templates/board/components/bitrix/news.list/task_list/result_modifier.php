<?php
/** @var array $arResult */
/** @var array $USER */


if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}
$currentTeam = ScrumBoard\Helper::GetUserTeam($USER->GetID());
$allowedTeamBoards = ScrumBoard\Helper::GetTeamBoards($currentTeam);
$sectionResult = array();
$sectionResultScndLevel = array();
$sectionConnections = array();
$uniqueTags = array();
$currentBoard = $_GET['board'];
$allowedSections = array();

$IsTeamLeader = ScrumBoard\Helper::IsTeamLeader($USER->GetID(),$currentTeam);
if(!$currentBoard){
    $currentBoard = array_key_first($allowedTeamBoards);
}
$allowBoard = in_array($currentBoard,$allowedTeamBoards);
if(in_array($currentBoard,$allowedTeamBoards)){
    $arFilter = Array('IBLOCK_ID'=> 1);
    $db_list = CIBlockSection::GetList(Array(), $arFilter, true,array('ID','DEPTH_LEVEL','IBLOCK_SECTION_ID','NAME'));
    $db_list->NavStart(20);
    while($ar_result = $db_list->GetNext()) {
        $sectionResult[] = $ar_result;
    }

    foreach ($sectionResult as $key => $section){
        if(($section['ID'] == $currentBoard) || ($section['IBLOCK_SECTION_ID'] == $currentBoard)){
            if($section['DEPTH_LEVEL'] == 1){
                $sectionConnections[$section['ID']]['CHILDREN'] = array();
                $sectionConnections[$section['ID']]['ELEMENTS'] = array();
            } else {
                $sectionResultScndLevel[] = $section;
                $allowedSections[] = $section['ID'];
                $sectionConnections[$section['IBLOCK_SECTION_ID']]['CHILDREN'][$section['ID']] = $section;
                $sectionConnections[$section['IBLOCK_SECTION_ID']]['CHILDREN'][$section['ID']]['CHILDREN'] = array();
                $sectionConnections[$section['IBLOCK_SECTION_ID']]['CHILDREN'][$section['ID']]['ELEMENTS'] = array();
            }
        }


    }
    if(count($sectionConnections[$currentBoard]['CHILDREN'])){

        foreach($arResult['ITEMS'] as $key => $item){
            if(in_array($item['IBLOCK_SECTION_ID'],$allowedSections)){
                foreach ($item['PROPERTIES']['TASK_TAG']['VALUE'] as $key=> $tag){
                    if(!in_array($uniqueTags,$tag)){
                        $uniqueTags[] = $tag;
                    }
                }
                $sectionConnections[$currentBoard]['CHILDREN'][$item['IBLOCK_SECTION_ID']]['ELEMENTS'][] = $item;
            }

        }


    }
    if(empty($sectionConnections[$currentBoard]['CHILDREN'])){
        $arResult['CURRENT_STRUCTURE'] = $sectionResultScndLevel;
    }else{
        $arResult['CURRENT_STRUCTURE'] = $sectionConnections[$currentBoard]['CHILDREN'];
    }
    $arResult['VISUAL_PREF'] = array(
        'to-do',
        'in-work',
        'done',
        'not-done',
    );
    $arResult['TAGS'] = $uniqueTags;
    $arResult['IS_LEADER'] = $IsTeamLeader;

    $arResult['CURRENT_TEAM_NAME'] = ScrumBoard\Helper::GetTeamName($currentTeam);
}
$arResult['CURRENT_BOARD'] = $currentBoard;
$arResult['CURRENT_TEAM'] = $currentTeam;
$arResult['BOARD_ALLOWED'] = $allowBoard;
?>

