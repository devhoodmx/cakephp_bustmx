<?php
App::uses('AppModel', 'Model');
/**
 * RequestVacancy Model
 *
 */
class RequestVacancy extends AppModel {
	public $name = 'RequestVacancy';

	public $virtualFields = array(
		'display_sent' => 'DATE_FORMAT(RequestVacancy.created, "%d/%m/%y %H:%i")',
		'display_vacancy' => '(SELECT name FROM categories WHERE categories.id = RequestVacancy.vacancy_id)'
	);
	

    public $actsAs = array(
		'Media' => array(
			'document' => array(
				'private' => false,
				'multiple' => false,
				'max-size' => '20MB',
				'files' => array(
					'file' => array(
						'types' => array('pdf'),
						'default' => true,
					)
				),
				'services' => false
			),
		),
		'Containable',

	);
	public $validationDomain = 'error';
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
        'email' => array(
            'notBlank' => array('rule' => 'notBlank'),
			'email' => [
				'rule' => 'email',
				'allowEmpty' => true
			]

        ),
        'vacancy_id' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
        'message' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
		'phone' => [
			'notEmpty' => [
				'rule' => 'notEmpty'
			],
			'numeric' => [
				'rule' => 'numeric'
			]
            
        ],
	);

	public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'vacancy_id'
        )
    );
}

