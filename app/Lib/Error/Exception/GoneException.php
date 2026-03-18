<?php
/**
 * Represents an HTTP 410 error.
 *
 * @package       Cake.Error
 */
class GoneException extends HttpException {
/**
 * Constructor
 *
 * @param string $message If no message is given 'Gone' will be the message
 * @param string $code Status code, defaults to 410
 */
	public function __construct($message = null, $attributes = array()) {
		$this->_attributes =  $attributes;
		if (empty($message)) {
			$message = 'Gone';
		}

		parent::__construct($message, 410);
	}

	public function getAttributes() {
		return $this->_attributes;
	}
}
?>