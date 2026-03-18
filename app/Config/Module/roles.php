<?php
$config = array(
	'vars' => array(
		'menuItemKey' => 'configurations',
		'submenuItemKey' => 'roles'
	),
	'views' => array(
		'admin_index' => array(
			'findParams' => array(
				'limit' => 25,
				'contain' => false
			),
			'list' => array(
				'fields' => array(
					'name',
					'key'
				),
				'actions' => array(
					'users' => [
						'url' => [
							'controller' => 'users',
							'action' => 'index',
							'query' => ['role_id' => 'Role.id']
						]
					],
					'edit',
					'delete'
				)
			)
		),
		'admin_delete' => array()
	)
);
