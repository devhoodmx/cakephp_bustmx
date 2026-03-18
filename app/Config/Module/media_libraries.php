<?php
$config = [
	'vars' => [
		'menuItemKey' => 'content',
		'submenuItemKey' => 'media_libraries'
	],
	'form' => [
		'fields' => [
			'main' => [
				'parent_id' => [
					'type' => 'select',
					'empty' => 'Inicio'
				],
				'name' => [
					'type' => 'text'
				],
				'color' => [
					'type' => 'color',
					'default' => '#cccccc'
				]
			]
		]
	],
	'findParams' => [
		'contain' => false
	],
	'views' => [
		'admin_add' => [
			'redirect' => ['action' => 'index', 'params' => ['MediaLibrary.parent_id']]
		],
		'admin_edit' => [
			'redirect' => ['action' => 'index', 'params' => ['MediaLibrary.id']],
			'fields' => [
				'main' => [
					'slug' => [
						'type' => 'text',
						'prepend' => '<i class="fa fa-key"></i>',
						'append' => '<a href="#" data-clipboard="$#MediaLibrarySlug"><i class="fa fa-copy"></i></a>'
					]
				]
			]
		],
		'admin_delete' => []
	]
];
?>
