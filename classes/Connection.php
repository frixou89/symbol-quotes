<?php
namespace app;

/**
 * Class Connection
 */
class Connection
{
	protected $pdo;
	protected $fpdo;

    /**
     * Class constructor
     * 
     * Prepare the FluentPDO connector for reusability
     */
    function __construct()
    {
        $this->pdo  = new \PDO('mysql:dbname='.getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
		$this->fpdo = new \FluentPDO($this->pdo);
    }

    /**
     * Return a FluentPDO connection instance
     * @return \FluentPDO
     */
    public function getFpdo() {
    	$c = new self();
    	return $c->fpdo;
    }
}