<?php
$plugin = 'templates';
$prefixes = Configure::read('Templates.prefixes');

foreach ($prefixes as $prefix) {
	$params = array('plugin' => $plugin, 'controller' => $plugin, 'prefix' => $prefix, $prefix => true);
	Router::connect("/{$plugin}/{$prefix}", $params + array('action' => 'index'));
	Router::connect("/{$plugin}/{$prefix}/:action/*", $params);
}
Router::connect(
	"/{$plugin}",
	array('plugin' => $plugin, 'controller' => $plugin, 'action' => 'index')
);
Router::connect(
	"/{$plugin}/:action/*",
	array('plugin' => $plugin, 'controller' => $plugin)
);
