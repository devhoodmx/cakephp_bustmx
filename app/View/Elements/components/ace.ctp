<?php
$this->Package->append('view', 'css', array(
	'component.ace',
));
$this->Package->append('vendor', 'js', array(
	'vendor.ace.ace',
));
$this->Package->append('view', 'js', array(
	'component.ace',
));

$language = !empty($language) ? $language : 'plain_text';
$languages = isset($languages) ? $languages : false;
$input = array_merge(
	array(
		'id' => false,
		'key' => 'value',
		'type' => 'hidden',
		'class' => 'value'
	),
	empty($input) ? array() : array_intersect_key($input, array_flip(array('key', 'label')))
);
?>

<div data-component='ace' class='ace-component'>
	<?php
	// Language
	$opts = array(
		'id' => false,
		'label' => false,
		'class' => 'language',
		'value' => $language
	);

	if ($languages) {
		$opts['options'] = array(
			'plain_text' => __('Texto plano'),
			'javascript' => __('JavaScript'),
			'php' => __('PHP'),
			'html' => __('HTML'),
			'css' => __('CSS'),
			'markdown' => __('Markdown'),
		);
	} else {
		$opts['type'] = 'hidden';
	}

	echo $this->BootForm->input('language', $opts);

	// Editor
	echo $this->Html->tag('div', '', array('class' => 'editor'));

	// Input
	$inputKey = $input['key'];
	unset($input['key']);
	echo $this->BootForm->input($inputKey, $input);
	?>
</div>
