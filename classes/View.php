<?php
namespace app;

/**
 * View class is responsible for rendering .php files from the /views directory
 */
class View
{
	/**
	 * Data to pass in the view file
	 * @var array The data
	 */
	private $data = [];
	/**
	 * The content to render
	 * @var boolean|string
	 */
	private $render = false;

	/**
	 * Js script to load in the view file
	 * @var null|string
	 */
	public $js = null;

	/**
	 * Class constructor
	 * 
	 * Usage: $view = new View(<viewFile>, <data>);
	 * 
	 * @param string $viewFile The view file to render
	 * @param array  $data The data to pass to view file
	 */
	function __construct($viewFile, $data = [])
	{
		try {
			$file = '../views/' . strtolower($viewFile) . '.php';

			// Check if file exists
			if (file_exists($file)) {
				$this->render = $file;
			} else {
				$this->render = false;
				throw new Exception ('View file: ' . $viewFile . ' not found!');
			}

			// Check if data is an array
			if (!empty($data) && !is_array($data)) {
				$this->data = [];
				throw new Exception ('$data must be an array.');
			} else {
				self::assign($data);
			}
		}
		catch (Exception  $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Registers JavaScript to the rendered view
	 * @param  string $js
	 */
	public function registerJs($js) {
		$this->js = $js;
	}

	/**
	 * Assigns data to view
	 * @param  array $data The data to assign
	 */
	protected function assign($data)
	{
		foreach ($data as $key => $value) {
			$this->data[$key] = $value;
		}
	}

	/**
	 * Get the rendered file on class destruction
	 */
	function __destruct()
	{
		// Extract data to view
		if ($this->data) {
			// This will assign array keys to variables
			extract($this->data);
		}
		// Include the view file
		if ($this->render) {
			include($this->render);
		}
	}
}
?>