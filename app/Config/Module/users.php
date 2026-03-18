<?php
$config = array(
	'vars' => array(
		'menuItemKey' => 'configurations',
		'submenuItemKey' => 'users',
		'components' => [
			'search' => true
		]
	),
	'form' => array(
		'size' => '4',
		'fields' => array(
			'main' => array(
				'name' => 'text',
				'last_name' => 'text',
				'email' => 'email',
				'username' => 'text',
				'_password' => [
					'type' => 'password',
					'autocomplete' => 'new-password'
				],
				'_password_confirmation' => 'password',
				'phone' => array(
					'type' => 'text',
					'placeholder' => '999 9442222'
				),
				'bio' => 'textarea',
				'role_id' => array(
					'type' => 'select',
					'empty' => __d('error', 'in-list')
				),
				'active' => array(
					'type' => 'checkbox',
					'legend' => false
				)
			),
			'aside' => array(
				'profile' => array(
					'profile' => 'media',
				)
			)
		)
	),
	'findParams' => array('contain' => 'Media'),
	'views' => array(
		'admin_index' => array(
			'add' => true,
			'findParams' => array(
				'limit' => 25,
				'contain' => array('Media', 'Role'),
				'order' => array('User.id' => 'DESC')
			)
		),
		'admin_add' => array(
			'redirect' => array('action' => 'index')
		),
		'admin_edit' => array(
			'redirect' => array('action' => 'index')
		),
		'admin_delete' => array(),
		'admin_toggle_field' => array('active')
	)
);
