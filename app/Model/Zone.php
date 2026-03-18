<?php
App::uses('AppModel', 'Model');

class Zone extends AppModel {
	public $name = 'Zone';

	public $order = [];

	public $actsAs = [
		'Containable',
		'Loggable'
	];

	public $belongsTo = [
		'Country'
	];

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order[$this->alias . '.name'] = 'ASC';
	}
}
?>
