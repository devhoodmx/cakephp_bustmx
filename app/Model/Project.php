<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 */
class Project extends AppModel {
	public $name = 'Project';

	public $virtualFields = array(
		'display_created' => 'DATE_FORMAT(Project.created, "%d/%m/%y %H:%i")',
	
	);

	public $hasAndBelongsToMany = array(
		'Category' => array(
			'joinTable' => 'categories_projects',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'category_id',
			'unique' => true
		)
	);

    public $actsAs = array(
		'Media' => array(
			'cover' => array(
				'private' => false,
				'multiple' => false,
				'max-size' => '40MB',
				'files' => array(
					'image' => array(
						'types' => array('jpg', 'jpeg', 'png'),
						'default' => true,
						'custom' => array(
							'view' => array(
								'filters' => array(
									'resizeToWidthHeight' => array(1920, 1080),
								)
							),
							'index' => array(
								'filters' => array(
									'resizeToWidthHeight' => array(340, 512)
								)
							),
							'card' => array(
								'filters' => array(
									'resizeToWidthHeight' => array(440, 730)
								)
							)
						)
					),
					'video'
				),
				'services' => false
			),
            'gallery' => array(
				'private' => false,
				'multiple' => true,
				'max-size' => '100MB',
				'files' => array(
					'image' => array(
						'types' => array('jpg', 'jpeg', 'png'),
						'default' => true,
						'custom' => array(
							'view' => array(
								'filters' => array(
									'resizeAndCrop' => array(1112, 832),
								)
							),
							'index' => array(
								'filters' => array(
									'resizeAndCrop' => array(524, 392)
								)
							),
						)
					),
					'video'
				),
				'services' => false
			),
			
		),
		'Containable',

	);

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
        'company' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
		'services' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
        'description' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
	);
}