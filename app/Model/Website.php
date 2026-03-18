<?php
App::uses('AppModel', 'Model');

class Website extends AppModel {
	public $name = 'Website';

	public $actsAs = array(
		'Containable'
	);
}
?>
