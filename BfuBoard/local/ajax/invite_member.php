<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$data = $_POST;
$teamName = $_POST['team-name'];
$teamInviteLink = 'http://board.lynx-digital.ru/invite.php?team_id='.$_POST['team-id'];
$mailTo = $_POST['email-to'];

$mail = $mailTo; // ваш email
$text = "Уважемый пользователь! Вы были приглашены в команду $teamName. Для подтверждения присоединения к команде, пройдите по ссылке: $teamInviteLink" ; // тема письма
$subject = "Приглашение в команду"; // текст письма
mail($mail, $subject, $text);
