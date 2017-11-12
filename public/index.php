<?php
require(__DIR__ . '/../vendor/autoload.php');

// Load dotenv
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

use app\View;

// Grabs the URI and breaks it apart in case we have querystring params
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

// Basic routing
switch ($request_uri[0]) {
    // Home
    case '/':
        $view = new View('home', [
        	'title' => 'Symbol Quotes'
        ]);
        break;

    // Submit
    case '/submit':
        require 'submit.php';
        break;

    // Search symbols
    case '/search-symbols':
        require 'search_symbols.php';
        break;

    // Everything else
    default:
        header('HTTP/1.0 404 Not Found');
        $view = new View('404', [
        	'title' => '404: Page Not Found'
        ]);
        break;
}