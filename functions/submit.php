<?php
use app\Validate;

// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	header("HTTP/1.0 405 Method Not Allowed"); die();
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
	header("HTTP/1.0 400 Bad Request");
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
// Stop script execution if errors are found
if ($errors) {
	$result['errors'] = $errors;
	header("HTTP/1.0 400 Bad Request");
	echo json_encode($result); die();
}

// Send mail to user
// Create the Transport
$transport = (new Swift_SmtpTransport(getenv('MAILER_HOST'), 25))
  ->setUsername(getenv('MAILER_USER'))
  ->setPassword(getenv('MAILER_PASSWORD'));
// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);
// Create a message
$message = (new Swift_Message("$symbol - quotes"))
  ->setFrom([getenv('MAILER_EMAIL') => getenv('MAILER_NAME')])
  ->setTo([$email])
  ->setBody("From $start to $end"); // Dates are already validated so we don't need to check again
// Send the message
$result = $mailer->send($message);

header("HTTP/1.0 200 ok");
echo json_encode($result); die();