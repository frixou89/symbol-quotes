<?php
// Prevent GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo 'GET requests not allowed'; die();
}

