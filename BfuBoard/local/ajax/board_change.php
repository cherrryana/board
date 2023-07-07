<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

$data = $_POST;
$result = array(
    'name' => $data['task-name'],
    'description' => $data['task-description'],
    'image' => false,
    'date-end' => $data['task-date'],
    'member-list' => false,
    'status' => $data['task-status'],
    'id' => $data['id'],
    'operation' => $data['operation']
);
$dataHandler = new \ScrumBoard\DataHandler($result);
$dataHandler -> Initialize();