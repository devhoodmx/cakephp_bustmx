<?php
$id = empty($id) ? '' : $id;
$class = sprintf('email-component%s', (empty($class) ?  '' : ' ' . $class));
$icon = isset($icon) ? $icon : true;
$email = isset($email) ? $email : null;

// Email
// Supports attributes to, cc, bcc, subject & body
if (is_array($email)) {
	$email = array_merge(
		['to' => null],
		$email
	);
} else {
	$email = ['to' => $email];
}
if ($email['to'] === null && !empty(Configure::read('App.configurations.contact-email'))) {
	$email['to'] = Configure::read('App.configurations.contact-email');
}

// Title
if (!isset($title)) {
	$title = $email['to'];
}
?>
<?php
$_title = '';
$url = sprintf('mailto:%s', $email['to']);
$attrs = array(
	'data-component' => 'email',
	'data-email' => $email['to'],
	'class' => $class,
	'escape' => false
);

if ($id) {
	$attrs['id'] = $id;
}
if ($icon) {
	$_icon = [
		'value' => 'fas fa-envelope',
		'type' => null
	];

	if (is_string($icon)) {
		$_icon['value'] = $icon;
	} elseif (is_array($icon)) {
		$_icon = array_merge($_icon, $icon);
	}

	if ($_icon['type'] == 'image') {
		$_title = $this->Html->image(
			$_icon['value'],
			[
				'class' => 'email-icon',
				'alt' => __('Email')
			]
		);
	} else {
		$_title = sprintf("<i class='email-icon %s'></i>", $_icon['value']);
	}
}
if (!empty($title)) {
	$_title .= sprintf(
		"<span class='email-title'>%s</span>",
		str_replace('{{ email }}', $email['to'], $title)
	);
}

// URL
$opts = ['cc', 'bcc', 'subject', 'body'];
$query = [];

foreach ($opts as $opt) {
	if (!empty($email[$opt])) {
		$value = $email[$opt];

		if ($opt == 'body') {
			// Each line should be separated with a CRLF (\r\n)
			// Replace all Unicode newlines. See https://stackoverflow.com/questions/7836632/how-to-replace-different-newline-styles-in-php-the-smartest-way/7836692#7836692
			$value = preg_replace('~\R~u', "\r\n", $value);
		}

		$query[$opt] = $value;
	}
}
if (!empty($query)) {
	$url .= '?' . http_build_query($query, null, '&', PHP_QUERY_RFC3986);;
}

echo $this->Html->link(
	$_title,
	$url,
	$attrs
);
?>
