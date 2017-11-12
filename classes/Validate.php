<?php
namespace app;

use app\Connection;
/**
 * Validate class
 */
class Validate
{	
	/**
	 * Email validator
	 * @param  string $email The email to validate
	 * @return bool Retruns true if $email is valid
	 */
	public static function email($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    return false;
		}
		return true;
	}

	/**
	 * Date format validator
	 * Checks if date is in YYYY-mm-dd format
	 * @param  string $date
	 * @return bool Returns true if date is in YYYY-mm-dd format
	 */
	public static function dateFormat($date) {
		if(preg_match('/\d{4}-\d{2}-\d{2}/', $date)){
			return true;
		}
		return false;
	}

	/**
	 * Checks if selected symbol exists
	 * @param  string $symbol
	 * @return bool Returns true if symbol exists
	 */
	public static function symbolExists($symbol) {
		$query = Connection::getFpdo()->from('symbols')->where('value', $symbol)->execute();
		if ($query->fetchAll()) {
			return true;
		} else {
			return false;
		}
	}
}