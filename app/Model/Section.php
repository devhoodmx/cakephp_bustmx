<?php
App::uses('AppModel', 'Model');

class Section extends AppModel {
	public $name = 'Section';

	public $order = [
		'Section.page' => 'ASC',
		'Section.order' => 'ASC'
	];

	public $actsAs = [
		'Media' => [
			'gallery' => [
				'private' => false,
				'multiple' => true,
				'max-size' => '20MB',
				'files' => [
					'image' => [
						'types' => ['jpg', 'jpeg', 'png'],
						'default' => true,
						'custom' => [
							'view' => [
								'filters' => [
									'resizeAndCrop' => [280, 280]
								]
							]
						]
					]
				],
				'services' => false
			],
			'archive' => array(
				'private' => FALSE,
				'multiple' => TRUE,
				'max-size' => '300MB',
				'files' => array(
					'file' => array(
						//'types' => array('docx')
					)
				),
				'services' => FALSE
			)
		],
		'Containable',
		'Loggable'
	];

	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => 'notBlank'
			]
		],
		'key' => [
			'notBlank' => [
				'rule' => 'notBlank'
			],
			'isUnique' => [
				'rule' => 'isUnique'
			]
		]
	];
}
?>
