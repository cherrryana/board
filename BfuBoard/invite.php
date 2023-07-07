<?php require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$teamID = $_GET['team_id'];
$userID = $USER->GetID();
ScrumBoard\Helper::AddMemberToTeam($teamID,$userID);
header("Location: http://board.lynx-digital.ru/");
exit( );
?>
