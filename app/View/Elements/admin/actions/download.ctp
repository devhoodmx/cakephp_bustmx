<?php
$ext = isset($ext) ? $ext : null;
$url = !empty($url) ? $url : null;
$title = __('Descargar');
$class = sprintf('btn %s', !empty($class) ? $class : 'btn-info btn-sm');

// Ext
if (empty($url) && empty($ext)) {
	$ext = 'csv';
} elseif (is_array($url) && !empty($url['ext'])) {
	$ext = $url['ext'];
}

// URL
if (empty($url)) {
	$url = ['action' => 'index', 'ext' => $ext];
}
if (!empty($this->request->query) && is_array($url)) {
	$url['?'] = $this->request->query;
}

// Title
if ($ext) {
	$title = __('Descargar %s', strtoupper($ext));
}

echo $this->Html->link(
	'<i class="fas fa-download"></i>',
	$url,
	[
		'class' => $class,
		'title' => $title,
		'escape' => false
	]
);
?>
