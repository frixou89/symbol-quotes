<?php
// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo 'GET requests not allowed'; die();
}

header('Content-Type: application/json');

if (!isset($_POST['q'])) {
	return null; die();
}
$keyword = $_POST['q'];

$query = \app\Connection::getFpdo()->from('symbols')->where("value like '%$keyword%'")->execute();
$result	= $query->fetchAll();
$data = [];
foreach ($result as $row) {
	$data[] = [
		'value' => $row['value'],
		'data' => [
            'content' => '<div>'.$row['value'].'</div>',
        ],
	];
}
echo json_encode($data);