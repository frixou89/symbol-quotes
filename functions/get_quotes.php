<?php
// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo 'GET requests not allowed'; die();
}

header('Content-Type: application/json');

if (!isset($_POST['s']) || empty($_POST['s'])) {
	header("HTTP/1.0 400  Bad Request"); die();
}
$symbol = $_POST['s'];

$data = file_get_contents("https://www.google.com/finance/historical?output=csv&q=$symbol");
$csv = explode("\n",$data);
$dataArray = array_map('str_getcsv', $csv);

$results = [];
foreach ($dataArray as $key => $row) {
	// Skip row if date is empty or not set
	if (!isset($row[0]) || !$row[0]) {
		continue;
	}
	// Set first row as headers
	if ($key === 0) {
		$results['headers'] = $row;
		continue;
	}
	// Format quotes
	$results['quotes'][] = [
		'date' => date('Y-m-d', strtotime($row[0])), // Format date to Y-m-d
		'open' => isset($row[1]) ? $row[1] : 0,
		'high' => isset($row[2]) ? $row[2] : 0,
		'low' => isset($row[3]) ? $row[3] : 0,
		'close' => isset($row[4]) ? $row[4] : 0,
		'volume' => isset($row[5]) ? $row[5] : 0,
	];
}

// Get the last date (first date in quotes)
$results['date_to'] = date('Y-m-d', strtotime($results['quotes'][0]['date']));

// Get the first date (last date in quotes)
$results['date_from'] = date('Y-m-d', strtotime(end($results['quotes'])['date']));

// show results
echo json_encode($results);