<?php
$config = array(
	'behavior' => array(
		'max-size' 		=> '1MB'
	),
	'files' => array(
		'image' 	=> array(
			'thn' 		=> array(
				'filters' 	=> array(
					'resizeAndCrop' => array(255, 186)
				)
			),
			'img' => array(
				'filters' 	=> array(
					'resizeToMaxWidthHeight' => array(800, 800)
				)
			),
			'car' => array( // web page element image
				'filters' 	=> array(
					'resizeAndCrop' => array(350, 350)
				)
			),
			'raw' => array(
				'filters' => array()
			)
		)
	),
	'views' => array(
		'admin_delete' => array(),
		'admin_toggle_field' => array(
			'main' => array(
				'conditions' => array(),
				'foreignKey' => array('model', 'foreign_key', 'collection'),
				'unique' => true
			),
			'shared'
		)
	)
);
?>
