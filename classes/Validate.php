<?php
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
	public function email($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    return false;
		}
		return true;
	}

	/**
	 * Returns the HTML for an error message
	 * @param  string $text The error message
	 * @return string The HTML for the error message
	 */
	private function errorMessage($text) {
		return "<div class='invalid-feedback'>$text</div>";
	}
}