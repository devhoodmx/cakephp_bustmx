<?php
$id = empty($id) ? '' : $id;
$class = sprintf('address-component%s', (empty($class) ?  '' : ' ' . $class));
$icon = isset($icon) ? $icon : true;
$address = isset($address) ? $address : null;

// Parse address
if ($address === null && !empty(Configure::read('App.configurations.contact-address'))) {
	$address = Configure::read('App.configurations.contact-address');
}
if (!isset($title)) {
	$title = $address;
}
?>
<?php
$_title = '';
$attrs = array(
	'data-component' => 'address',
	'data-address' => $address,
	'class' => $class,
	'escape' => false
);

if ($id) {
	$attrs['id'] = $id;
}
if ($icon) {
	$_title = "<i class='address-icon fas fa-map-marker fa-flip-horizontal'></i>";
}
if (!empty($title)) {
	$_title .= sprintf(
		"<span class='address-title'>%s</span>",
		$this->Text->autoParagraph(str_replace('{{ address }}', $address, $title))
	);
}

$url = isset($url) ? $url : sprintf('https://www.google.com/maps/?q=%s', $address);

echo $this->Html->link(
	$_title,
	$url,
	$attrs
);
?>
