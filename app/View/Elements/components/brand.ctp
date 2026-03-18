<?php
$name = isset($name) ? $name : $config['App']['configurations']['general-company-name'];
$image = !empty($image) ? $image : null;
$class = sprintf('brand-component brand-link%s', (empty($class) ?  '' : ' ' . $class));
$title = $name;

// URL
if (!isset($url)) {
	$url = ['controller' => 'pages', 'action' => 'home'];

	if (sizeof(Configure::read('App.i18n.locales')) > 1) {
		$url['locale'] = $locale;
	}
}

// Image
if (!$image && !empty($config['App']['configurations']['general-company-logo'])) {
	$template = '/files/media/image/small_%s';

	if (strpos($config['App']['configurations']['general-company-logo'], '.svg')) {
		$template = '/files/media/svg/file_%s';
	}

	$image = sprintf(
		$template,
		$config['App']['configurations']['general-company-logo']
	);
}

if ($image) {
	$title = $this->Html->image(
		$image,
		[
			'class' => 'brand-image',
			'alt' =>  $name
		]
	);
}

echo $this->Html->link(
	$title,
	$url,
	[
		'class' => $class,
		'data-component' => 'brand',
		'escape' => false
	]
);
?>
