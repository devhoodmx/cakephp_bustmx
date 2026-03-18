<?php
$config = array(
	'vars' => array(
		'menuItemKey' => 'configurations',
		'submenuItemKey' => 'modules'
	),
	'form' => array(
		'size' => '12',
		'fields' => array(
			'main' => array(
				'name' => 'text',
				'model' => 'text',
				'category_id' => 'select'
			)
		)
	),
	'views' => array(
		'admin_edit' => array(),
		'admin_delete' => array()
	)
);