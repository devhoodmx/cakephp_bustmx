<?php
// Requires stylesheet component.font-awesome-5.brands
$id = empty($id) ? '' : $id;
$class = sprintf('whatsapp-component%s', (empty($class) ?  '' : ' ' . $class));
$node = empty($node) ? [] : $node;
$icon = isset($icon) ? $icon : true;
$phone = isset($phone) ? $phone : null;
$phoneNumber = '';
$message = isset($message) ? $message : null;

// Parse phone number
if ($phone === null && !empty(Configure::read('App.configurations.contact-whatsapp'))) {
	$phone = Configure::read('App.configurations.contact-whatsapp');
}
if (!empty($phone)) {
	// https://api.whatsapp.com/send?phone=529991446702
	$phoneNumber = preg_replace('/[^0-9]/', '', $phone);

	if (strlen($phoneNumber) == 10) {
		$phoneNumber = '52' . $phoneNumber;
	}
}
if (!isset($title)) {
	$title = $phone;
}
?>
<?php
$_title = '';
$url = 'https://api.whatsapp.com/send?';
$urlQuery = ['phone' => $phoneNumber];
$attrs = array(
	'data-component' => 'whatsapp',
	'data-phone' => $phoneNumber,
	'class' => $class,
	'escape' => false,
	'target' => '_blank'
);

if ($id) {
	$attrs['id'] = $id;
}
if ($icon) {
	$_title = "<i class='whatsapp-icon fab fa-whatsapp'></i>";
}
if (!empty($title)) {
	$_title .= sprintf(
		"<span class='whatsapp-title'>%s</span>",
		str_replace('{{ phone }}', $phone, $title)
	);
}
// URL
if (!empty($message)) {
	$urlQuery['text'] = $message;
}
$url .= http_build_query($urlQuery);
// Node
if ($node) {
	$attrs = array_merge($attrs, $node);
}

echo $this->Html->link(
	$_title,
	$url,
	$attrs
);
?>
