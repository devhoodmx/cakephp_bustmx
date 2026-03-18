<?php
App::uses('AppModel', 'Model');

class Role extends AppModel {
	public $name = 'Role';

	public $order = array('Role.name' => 'ASC');

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		),
		'key' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			)
		)
	);

	public $actsAs = array(
		'Acl' => array(
			'type' => 'requester'
		),
		'Containable',
		'Loggable'
	);

	public $hasMany = array(
		'User'
	);

	public function parentNode($type) {
		return null;
	}
}
