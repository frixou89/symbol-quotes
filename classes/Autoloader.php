<?php
/**
 * Autoloader class
 */
class Autoloader {
    static public function loader($className) {
    	// Specify filename path
        $filename = __DIR__ . "/" . str_replace("\\", '/', $className) . ".php";
        // Check if file exists and load it if it does
        if (file_exists($filename)) {
            include($filename);
            if (!class_exists($className)) {
                throw new \Exception('class '.$className.' does not exist.');
            }
            return true;
        } else {
        	throw new \Exception('File not found: '.$filename);
        }
    }
}

// Register ``loader()`` function for __autoload() implementation
spl_autoload_register('Autoloader::loader');

// Instantiate Classes
// $validation = new Validate();