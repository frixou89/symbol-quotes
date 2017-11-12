<?php
// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	header("HTTP/1.0 405 Method Not Allowed"); die();
}
// Set Content-Type to json 
header('Content-Type: application/json');
// Do not allow get requests to this script
if (!isset($_POST['s']) || empty($_POST['s'])) {
	header("HTTP/1.0 400  Bad Request"); die();
}
// Get symbol from post parameter 's'
$symbol = $_POST['s'];

// Get quotes from url using symbol. Supress warnings and handle empty results manually
$data = @file_get_contents("https://www.google.com/finance/historical?output=csv&q=$symbol");
if (!$data) {
	header("HTTP/1.0 404 Symbol not found"); die();
}
// Create an array with the separated values
$csv = explode("\n",$data);
// Generate array from separated values
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
	// Format quotes results
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