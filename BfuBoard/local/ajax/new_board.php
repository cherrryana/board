<?php require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$data = $_POST;
$name = $data['new-board-name'];
$teamID = $data['team_id'];
return ScrumBoard\Helper::CreateNewBoard($teamID,$name);