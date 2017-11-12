<?php
use app\Validate;

// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo 'GET requests not allowed'; die();
}
header('Content-Type: application/json');

$result = [];
$errors = [];

// Check for empty values
if (!isset($_POST['symbol']))
	$errors['symbol'] = 'Please select a symbol.';
if (!isset($_POST['start']))
	$errors['start'] = 'Please select a date.';
if (!isset($_POST['end']))
	$errors['end'] = 'Please select a date.';
if (!isset($_POST['email']))
	$errors['email'] = 'Please enter your email.';

// If any of the above is empty, return errors and stop script execution
if ($errors) {
	$result['errors'] = $errors;
	echo json_encode($result); die();
}

// Assign post parameters to variables
$symbol = $_POST['symbol'];
$start = $_POST['start'];
$end = $_POST['end'];
$email = $_POST['email'];

// Validate fields using app\Validate class
if (!Validate::symbolExists($symbol)) 
	$errors['symbol'] = 'Please select a symbol from the list';
if (!Validate::dateFormat($start)) 
	$errors['start'] = 'Please enter a date in <i>YYYY-mm-dd</i> format';
if (!Validate::dateFormat($end))
	$errors['end'] = 'Please enter a date in <i>YYYY-mm-dd</i> format';
if (!Validate::email($email))
	$errors['email'] = 'Please enter a valid email';

if ($errors) {
	$result['errors'] = $errors;
	echo json_encode($result); die();
}