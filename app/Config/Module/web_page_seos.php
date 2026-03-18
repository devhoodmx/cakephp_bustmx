<?php
$config = [
	'vars' => [
		'menuItemKey' => 'configurations',
		'submenuItemKey' => 'web_page_seos'
	],
	'form' => [
		'fields' => [
			'main' => []
		]
	],
	'findParams' => ['contain' => ['Media']],
	'views' => [
		'admin_index' => [],
		'admin_edit' => [
			'redirect' => ['action' => 'index']
		]
	]
];
?>
