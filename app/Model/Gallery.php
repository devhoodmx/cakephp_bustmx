<?php
App::uses('AppModel', 'Model');

class Gallery extends AppModel {
	public $name = 'Gallery';

	public $order = array(
		'Gallery.order' => 'ASC',
		'Gallery.created' => 'DESC'
	);

	public $actsAs = array(
		'Media' => array(
			'image' => array(
				'private' => false,
				'multiple' => true,
				'max-size' => '50MB',
				'files' => array(
					'image' => array(
						'types' => array('jpg', 'jpeg', 'png'),
						'default' => true,
						'custom' => array(
							'main' => array(
								'filters' => array(
									'resizeAndCrop' => array(1920, 1080)
								)
							),
							'raw' => array()
						)
					)
				),
				'services' => false
			),
		),
		'Containable'
	);

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		)
	);
}
?>
