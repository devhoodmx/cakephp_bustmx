<?php
$id = empty($id) ? '' : $id;
$class = sprintf('phone-component%s', (empty($class) ?  '' : ' ' . $class));
$icon = isset($icon) ? $icon : true;
$phone = isset($phone) ? $phone : null;
$phoneNumber = '';

// Parse phone number
if ($phone === null && !empty(Configure::read('App.configurations.contact-phone'))) {
	$phone = Configure::read('App.configurations.contact-phone');
}
if (!empty($phone)) {
	$phoneNumber = preg_replace('/[^0-9]/', '', $phone);
}
if (!isset($title)) {
	$title = $phone;
}
?>
<?php
$_title = '';
$attrs = array(
	'data-component' => 'phone',
	'data-phone' => $phoneNumber,
	'class' => $class,
	'escape' => false
);

if ($id) {
	$attrs['id'] = $id;
}
if ($icon) {
	$_title = "<i class='phone-icon fas fa-phone fa-flip-horizontal'></i>";
}
if (!empty($title)) {
	$_title .= sprintf(
		"<span class='phone-title'>%s</span>",
		str_replace('{{ phone }}', $phone, $title)
	);
}

echo $this->Html->link(
	$_title,
	sprintf('tel:%s', $phoneNumber),
	$attrs
);
?>
