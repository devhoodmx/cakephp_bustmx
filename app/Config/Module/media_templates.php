<?php
$config = array(
	'vars' => array(
		'menuItemKey' => 'comments',
		'submenuItemKey' => 'categories'
	),
	'form' => array(
		'size' => '4',
		'fields' => array(
			'main' => array(
				'username' => 'text',
				'name' => 'text',
				'last_name' => 'text',
				'curriculum' => 'media',
				'type' => 'select'
			),
			'aside' => array(
				'profile' => array(
					'profile' => 'media'
				)
			)
		)
	),
	'findParams' => array('contain' => 'Media'),
	'views' => array(
		'admin_index' => array(
			'findParams' => array(
				'limit' => 25,
				'contain' => array('Media')
			),
			'list' => array(
				'fields' => array(
					'Media.profile',
					'username',
					'name',
					'last_name'
				),
				'actions' => array(
					array(
						'gift' => array(
							'url' => array('action' => 'index'),
							'title' => 'hola'
						),
						'edit',
						'main' => array('type' => 'toggle'),
					),
					'options' => array(
						'header' => 'main',
						'edit',
						'fire' => array(
							'url' => array('action' => 'preferences', 'params' => array('MediaTemplate.id', 'MediaTemplate.last_name')),
							'title' => 'Preferencias'
						),
						'-',
						'active' => array('type' => 'toggle'),
						'delete'
					),
					'music' => array(
						'url' => array('action' => 'preferences', 'params' => array('MediaTemplate.id', 'MediaTemplate.last_name')),
						'title' => 'Preferencias'
					),
					'main' => 'toggle',
					'delete'
				)
			)
		),
		'admin_add' => array(
			'findParams' => array(),
			'redirect' => array('action' => 'edit', 'params' => array('MediaTemplate.id', 'MediaTemplate.name')),
			'fields' => array()
		),
		'admin_edit' => array(
			'findParams' => array(),
			'fields' => array(
				'main' => array(
					'gallery' => 'media',
				),
				'aside' => array(
					'archives' => array(
						'gallery' => 'media'
					)
				)
			)
		),
		'admin_delete' => array(),
		'admin_toggle_field' => array()
	)
);
