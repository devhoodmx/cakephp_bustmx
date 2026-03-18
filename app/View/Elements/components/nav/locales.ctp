<?php
$attrs = [];
$class = sprintf('locale-nav-component%s', (empty($class) ?  '' : ' ' . $class));
$locale = isset($locale) ? $locale : null;
$locales = !empty($locales) ? $locales : [];
$_url = [
	'controller' => $this->request->controller,
	'action' => $this->request->action
];
$url = isset($url) && is_array($url) ? $url : $_url;
$separator = isset($separator) ? $separator : null;
$items = [];

// Items
foreach ($locales as $_key => $_locale) {
	$localeKey = $_key;
	$item = [
		'name' => '',
		'url' => ''
	];

	if (is_array($_locale)) {
		$item = array_merge($item, $_locale);
	} else {
		$item['name'] = $_locale;
	}

	// Key
	if (!is_string($localeKey) && !empty($item['name'])) {
		$localeKey = strtolower($item['name']);
	}
	// Name
	if (empty($item['name']) && is_string($localeKey)) {
		$item['name'] = $localeKey;
	}
	// URL
	if (!$item['url']) {
		$item['url'] = array_merge(
			$url,
			['locale' => $localeKey]
		);
	}

	$items[$localeKey] = $item;
}
?>
<?php
echo $this->element('components/nav', [
	'class' => $class,
	'items' => $items,
	'active' => $locale,
	'separator' => $separator
]);
?>
