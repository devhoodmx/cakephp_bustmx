<?php
App::uses('AppModel', 'Model');

class Country extends AppModel {
	public $name = 'Country';

	public $order = [];

	public $actsAs = [
		'Containable',
		'Loggable'
	];

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order[$this->alias . '.name'] = 'ASC';
	}
}
?>
