<?php
// Title
$title = $config['App']['configurations']['website-title'];

if (!empty($properties['title'])) {
	$buffer = $properties['title'];

	if (!empty($item) && is_array($item)) {
		foreach ($item as $field => $value) {
			$buffer = str_replace(
				sprintf('{{ %s }}', $field),
				$value,
				$buffer
			);
		}
	}

	$title = __(
		'page-title',
		$buffer,
		$title
	);
}

$this->assign('title', $title);
$this->assign('setSocialMetaTitle',  $title);
?>

<?php
// Description
if (!empty($properties['description'])) {
	$this->assign('pageDescription', $properties['description']);
	$this->assign('setSocialMetaDescription',  $properties['description']);
}
?>

<?php
// Description
if (!empty($properties['image'])) {
	$imageMeta = Router::url(sprintf('/files/seo/image/img_%s', $properties['image']), true);
	$this->assign('setSocialMetaImage', $imageMeta);
}
?>

<?php
// Meta
if (!empty($properties['meta'])) {
	$this->append('meta', $properties['meta']);
}
?>

<?php
// Header code
if (!empty($properties['header_code'])) {
	$this->append('pageHeaderCode', $properties['header_code']);
}
?>

<?php
// Footer code
if (!empty($properties['footer_code'])) {
	$this->append('pageFooterCode', $properties['footer_code']);
}
?>
