<?php
$config = [
	'vars' => [
		'menuItemKey' => 'content',
		'submenuItemKey' => 'projects'
	],
	'form' => [
		'size' => '4',
		'fields' => [
			'main' => array(
				'name' => 'text',
				'company' => 'text',
				'categories' => array(
					'type' => 'element'
				),
				'active' => array(
					'type' => 'radio',
					'options' => array('1' => 'Si', '0' => 'No'),
					'legend' => '¿Publicar proyecto?',
					'default' => '1'

				),
				'main' => array(
					'type' => 'radio',
					'options' => array('1' => 'Si', '0' => 'No'),
					'legend' => '¿Mostrar en página de inicio?',
					'default' => '1'

				),
                'url' => 'text',
				'services' => 'ckeditor',
                'description' => 'ckeditor',
                'final_text' => 'ckeditor'

			),
            'aside' => array(
                'cover' => array(
					'cover' => 'media'
				),

            ),
		]
	],
    'findParams' => ['contain' => ['Media', 'Category']],
	'views' => [
		'admin_index' => [
			'findParams' => array(
				'limit' => 25,
                'contain' => array('Media', 'Category'),
				'order' => [
					'Project.id' => 'DESC'
				]
			),
			'list' => array(
				'fields' => array(
					'name',
                    'company',
                    'Media.cover',
                    'display_created'
				),
				'actions' => array(
					'active' => 'toggle',
					'main' => 'toggle',
					'edit',
					'delete'
				)
			)
		],
		'admin_add' => array(
			'redirect' => array(
				'controller' => 'projects', 'action' => 'edit', 'params' => array('Project.id', 'Project.name')
			),
		),
		'admin_edit' => [
			'redirect' => array('action' => 'index'),
            'fields' => [
                'main' => [
                    'gallery' => array(
                        'gallery' => 'media'
                    )
				],

            ]
		],
		'admin_delete' => [],
		'admin_toggle_field' =>['active','main']
	]
];

?>
