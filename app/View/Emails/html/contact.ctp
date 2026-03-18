<?php
$model = 'ContactEmail';
$modelKey = Inflector::underscore($model);
$inputs = [
	'name',
	'last_name',
	'email',
	'phone',
	'message' => 'textarea'
];
?>
<h1 style="display: block;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 100%;letter-spacing: normal;margin-top: 0;margin-right: 0;margin-bottom: 20px;margin-left: 0;text-align: left;color: #202020;"><?php echo __('Mensaje de contacto'); ?></h1>

<?php
$body = [];

foreach ($inputs as $key => $input) {
	$type = 'text';
	$inputKey = $input;

	if (is_string($key)) {
		$type = $input;
		$inputKey = $key;
	}

	if (isset($data[$model][$inputKey])) {
		$label = __d($modelKey, Utility::slug($inputKey));
		$value = htmlspecialchars($data[$model][$inputKey]);
		$entry = '';

		if ($type == 'textarea') {
			$value = $this->Text->autoParagraph($value);
		}

		$entry = sprintf(
			'<strong>%s:</strong> %s',
			$label,
			$value
		);
		$body[] = $entry;
	}
}

echo implode('<br />', $body);
?>
