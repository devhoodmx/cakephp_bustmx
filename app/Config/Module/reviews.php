<?php
$config = [
	'vars' => [
		'menuItemKey' => 'content',
		'submenuItemKey' => 'reviews'
	],
	'form' => [
		'size' => '4',
		'fields' => [
			'main' => array(
				'name' => 'text',
                'active' => array(
                    'type' => 'radio' ,
                    'options' => ['1' => 'Sí', '0' => 'No'],
                    'legend' => '¿Publicar review?',
                    'default' => '1'
                ),
				'description' => 'ckeditor',
			),
		]
	],
	'views' => [
		'admin_index' => [
			'findParams' => array(
				'limit' => 25,
				'order' => [
					'Review.id' => 'DESC'
				]
			),
			'list' => array(
				'fields' => array(
					'name',
                    'display_created'
				),
				'actions' => array(
                    'active' => 'toggle',
					'edit',
					'delete'
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
        'admin_toggle_field' => array('active','main')
	]
];

?>