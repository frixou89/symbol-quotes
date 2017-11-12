<?php
namespace app;
/**
 * summary
 */
class Connection
{
	protected $pdo;
	protected $fpdo;

    /**
     * summary
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