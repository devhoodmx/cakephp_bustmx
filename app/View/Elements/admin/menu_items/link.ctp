<?php
$link = [];
$icon = 'file-alt';
$type = $item['MenuItem']['type'];

if ($type == 'internal') {
	if ($item['MenuItem']['web_page_id']) {
		$link['name'] = Router::url(['controller' => 'web_pages', 'action' => 'view', 'admin' => false]);

		if (!$config['App']['webpages']['pretty-urls']) {
			$link['name'] .= '/';
		}
		$link['name'] .= $item['WebPage']['es_key'];

		$link['url'] = $link['name'];
	} else {
		$url = ['controller' => $item['MenuItem']['controller'], 'action' => $item['MenuItem']['action'], 'admin' => false, 'locale' => 'es'];
		$link['name'] = Router::url($url);
		$link['url'] = Router::url($url, true);
	}
} elseif ($type == 'external') {
	$icon = 'link';
	$url = $item['MenuItem']['es_url'];

	if (!preg_match('#^(mailto:|tel:|https?://|/)#', $url)) {
		$url = 'https://' . $url;
	}

	$link['name'] = $item['MenuItem']['es_url'];
	$link['url'] = $url;
} elseif ($type == 'header') {
	$icon = 'hashtag';
}
?>

<i class='far fa-fw fa-<?php echo $icon; ?>'></i>
<?php
if (!empty($link)) {
	echo $this->Html->link(
		$link['name'],
		$link['url'],
		['target' => '_blank']
	);
}
?>
