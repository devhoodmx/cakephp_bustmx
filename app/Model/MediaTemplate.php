<?php
App::uses('AppModel', 'Model');
/**
 * MediaTemplate Model
 *
 */
class MediaTemplate extends AppModel {
	public $name = 'MediaTemplate';

	public $validate = array(
		'username' => array(
			'email' => array(
				'rule' => 'email',
				'allowEmpty' => TRUE,
				'required' => 'create'
			)
		)
	);

	public $actsAs = array(
		//'Sortable',
		'Containable',
		'Media' => array(
			'gallery' => array(
				'private' => FALSE,
				'multiple' => TRUE,
				'max-size' => '3MB',
				'files' => array(
					'image' => array(
						'types' => array('jpg', 'png'),
						'default' => TRUE,
						'custom' => array(
							'format' => IMAGETYPE_PNG,
							'tiny' => array(
								'filters' => array(
									'resizeToWidth' => array(200),
									'grayScale' => array()
								)
							),
							'raw' => array()
						)
					),
					'audio'
				),
				'services' => FALSE
			),
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
			),
			'profile' => array(
				'private' => FALSE,
				'not-empty' => TRUE,
				'multiple' => FALSE,
				'not-empty' => TRUE,
				'max-size' => '3MB',
				'files' => array('image' => array()),
				'services' => FALSE
			),
			'curriculum' => array(
				'private' => TRUE,
				'multiple' => FALSE,
				'max-size' => '3MB',
				'files' => array(
					'file' => array()
				),
				'services' => FALSE
			)
		),
		'Loggable'
	);
}
?>