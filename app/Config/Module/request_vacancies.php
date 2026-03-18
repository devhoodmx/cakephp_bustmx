<?php
$config = [
	'vars' => [
		'menuItemKey' => 'content',
		'submenuItemKey' => 'request_vacancies'
	],
	'form' => [
		'size' => '4',
		'fields' => [
			'main' => array(
				'name' => array(
                    'type' => 'text',
                    'readonly' => true
                ),
				'email' => array(
                    'type' => 'text',
                    'readonly' => true
                ),
				'phone' => array(
                    'type' => 'text',
                    'readonly' => true
                ),
				'vacancy_id' => array(
					'label' => 'Vacantes',
                    'type' => 'select',
					'empty' => 'Seleccione una opción',
                   	'disabled' => true
                ),
				'message' => array(
                    'type' => 'textarea',
                    'readonly' => true
                ),
			),
            'aside' => array(
                'document' => array(
					'document' => 'media',
					
				)
            ),
		]
	],
    'findParams' => ['contain' => ['Media']],
	'views' => [
		'admin_index' => [
			'add' => false,
			'findParams' => array(
				'limit' => 25,
				'contain' => array('Media','Category'),
				'order' => [
					'RequestVacancy.id' => 'DESC'
				]
			),
			'list' => array(
				'fields' => array(
					'name',
					'display_vacancy',
					'Media.document',
					'display_sent',
				),
				'actions' => array(
					'edit',
					'delete',
					
				)
			)
		],
		'admin_add' => array(
			'redirect' => array('action' => 'index')
			
		),
		'admin_edit' => [
			'redirect' => array('action' => 'index')
		],
		'admin_delete' => [],
	]
];

?>