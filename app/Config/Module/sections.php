<?php
$config = [
	'vars' => [
		'menuItemKey' => 'content',
		'submenuItemKey' => 'sections'
	],
	'form' => [
		'fields' => [
			'main' => [
				'name' => [
					'type' => 'text',
					'placeholder' => 'Introducción'
				],
				'key' => [
					'type' => 'text',
					'placeholder' => 'home.intro'
				],
				'page' => [
					'type' => 'text',
					'placeholder' => 'Inicio'
				],
				'type' => [
					'type' => 'radio',
					'options' => [
						'text' => 'Texto',
						'image' => 'Imagen',
						'' => 'Texto e imagen',
						'code' => 'Código',
						'archive' => 'Archivo',
						'simple-text' => 'Texto simple'
					],
					'legend' => 'Tipo de contenido',
					'default' => 'text'
				],
				'deletable' => [
					'type' => 'radio',
					'options' => ['0' => 'No', '1' => 'Sí'],
					'legend' => 'Permitir borrar la sección',
					'default' => '0'
				]
			]
		]
	],
	'findParams' => ['contain' => ['Media']],
	'views' => [
		'admin_add' => [
			'redirect' => ['action' => 'index']
		],
		'admin_edit' => [
			'findParams' => ['contain' => ['Media']]
		],
		'admin_delete' => []
	]
];
?>
