<?php
class MaintenanceException extends CakeException {
	public function __construct($message = null, $attributes = array()) {
		$this->_attributes =  $attributes;
		if (empty($message)) {
			$message = 'Maintenance';
		}
		
		parent::__construct($message, 503);
	}
}
?>