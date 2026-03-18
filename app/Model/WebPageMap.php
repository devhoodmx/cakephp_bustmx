<?php
App::uses('AppModel', 'Model');

class WebPageMap extends AppModel {
	public $name = 'WebPageMap';

	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'latitude' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric'
			)
		),
		'longitude' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric'
			)
		),
		'zoom' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'allowEmpty' => true
			)
		)
	);

	public $belongsTo = array(
		'WebPageElement'
	);
}
?>
