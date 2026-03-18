<?php
App::uses('AppModel', 'Model');

class WebPageSeo extends AppModel {
	public $name = 'WebPageSeo';

	public $order = [
		'WebPageSeo.es_name' => 'ASC'
	];

	public $actsAs = [
		'Media' => array(
			'image' => array(
				'private' => false,
				'not-empty' => false,
				'multiple' => false,
				'max-size' => '3MB',
				'files' => array('image' => array()),
				'services' => false,
				'path' => 'seo'
			)
		),
		'Containable',
		'Loggable'
	];

	public $validate = [
		'key' => [
			'notBlank' => [
				'rule' => 'notBlank'
			],
			'isUnique' => [
				'rule' => 'isUnique'
			]
		],
		'es_name' => [
			'notBlank' => [
				'rule' => 'notBlank'
			]
		]
	];
}
?>
