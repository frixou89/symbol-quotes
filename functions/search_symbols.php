<?php
// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	header("HTTP/1.0 405 Method Not Allowed"); die();
}
// Set Content-Type to json 
header('Content-Type: application/json');

// Check if q parameter was sent
if (!isset($_POST['q'])) {
	header("HTTP/1.0 400  Bad Request"); die();
}
// Assign q parameter to $keyword
$keyword = $_POST['q'];
// Check if $keyword exists in our database
$query = \app\Connection::getFpdo()->from('symbols')->where("value like '%$keyword%'")->execute();
$result	= $query->fetchAll();
$data = [];
// Prepare results
foreach ($result as $row) {
	$data[] = [
		'value' => $row['value'],
		'data' => [
            'content' => '<div>'.$row['value'].'</div>',
        ],
	];
}
// Print results
echo json_encode($data);