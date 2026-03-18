<?php
App::uses('AppModel', 'Model');

class ContactEmail extends AppModel {
	public $name = 'ContactEmail';

	public $useTable = false;

	public $validationDomain = 'error';

	public $validate = array(
		'name' => array(
			'notBlank' => [
				'rule' => 'notBlank'
			]
		),
		// 'last_name' => array(
		// 	'notBlank' => array('rule' => 'notBlank')
		// ),
		'email' => array(
			'notBlank' => array('rule' => 'notBlank'),
			'email' => [
				'rule' => 'email',
				'allowEmpty' => true
			]
		),
		'subject' => array(
			'notBlank' => array('rule' => 'notBlank')
		),
		'message' => array(
			'notBlank' => [
				'rule' => 'notBlank'
			]
		)
	);

	protected $_schema = array(
		'name' => array('type' => 'string'),
		'last_name' => array('type' => 'string'),
		'email' => array('type' => 'string'),
		'phone' => array('type' => 'string'),
		'message' => array('type' => 'text')
	);
}
?>
