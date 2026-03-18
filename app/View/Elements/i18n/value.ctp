<?php
$buffer = [];
$locales = Configure::read('App.i18n.locales');
$separator = isset($separator) ? $separator : ' / ';

foreach ($locales as $_locale) {
	$buffer[] = $data[$_locale . '_' . $field];
}

echo implode($separator, $buffer);
?>
