<?php
$config = array(
	'vars' => array(
		'menuItemKey' => 'content',
		'submenuItemKey' => 'web_pages'
	),
	'form' => array(
		'size' => '4',
		'fields' => array(
			'main' => array(
				'es_name' => array(
					'type' => 'text',
					'label' => __d('web_page', 'name')
				),
				'es_key' => array(
					'type' => 'text',
					'label' => __d('web_page', 'key'),
					'prepend' => '/',
					'placeholder' => __d('web_page', 'placeholder-key-es')
				),
				'es_meta_tags' => array(
					'type' => 'textarea',
					'label' => __d('web_page', 'meta-tags')
				),
				'active' => array(
					'type' => 'checkbox',
					'legend' => false
				)
			)
		)
	),
	'views' => array(
		'admin_add' => array(
			'findParams' => array(),
			'redirect' => array('action' => 'view', 'params' => array('WebPage.id', 'WebPage.name')),
			'fields' => array()
		),
		'admin_edit' => array(),
		'admin_delete' => array(),
		'admin_toggle_field' => array('active')
	)
);
