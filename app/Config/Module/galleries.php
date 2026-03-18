<?php
$config = array(
	'vars' => array(
		'menuItemKey' => 'content',
		'submenuItemKey' => 'galleries'
	),
	'form' => array(
		'fields' => array()
	),
	'findParams' => array('contain' => array('Media')),
	'views' => array(
		'admin_add' => array(
			'redirect' => array('action' => 'edit', 'params' => array('Gallery.id', 'Gallery.name')),
			'fields' => array(
				'main' => array(
					'name' => array('type' => 'text'),
					'published' => array('type' => 'checkbox', 'legend' => false)
				)
			)
		),
		'admin_edit' => array(
			'findParams' => array('contain' => array('Media')),
			'redirect' => array('action' => 'index'),
			'fields' => array(
				'main' => array(
					'name' => array('type' => 'text'),
					'image' => 'media',
					'published' => array('type' => 'checkbox', 'legend' => false)
				)
			),
		),
		'admin_index' => array(
			'findParams' => array('contain' => 'Media'),
			'list' => array(
				'fields' => array(
					'Media.image' => array(
						'viewOnly' => true
					),
					'name'
				),
				'actions' => array(
					'published' => 'toggle',
					'edit',
					'delete'
				)
			)
		),
		'admin_delete' => array(),
		'admin_toggle_field' => array('published')
	)
);
?>
