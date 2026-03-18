<?php
$config = [
	'vars' => [
		'menuItemKey' => 'content',
		'submenuItemKey' => 'plans'
	],
	'form' => [
		'size' => '4',
		'fields' => [
			'main' => array(
				'name' => 'text',
				'price' => 'text',
				'list' => 'ckeditor',
			),
		]
	],
	'views' => [
		'admin_index' => [
			'findParams' => array(
				'limit' => 25,
				'order' => [
					'Plan.id' => 'DESC'
				]
			),
			'list' => array(
				'fields' => array(
					'name',
					'formatted_price',
                    'display_created'
				),
				'actions' => array(
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
	]
];

?>