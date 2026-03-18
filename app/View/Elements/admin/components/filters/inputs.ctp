<?php
$labels =  isset($labels) ? $labels : false;
$advanced =  isset($advanced) ? $advanced : false;
?>
<?php
foreach ($filters as $key => $filter) {
	$options = [
		'type' => 'select',
		'id' => false,
		'name' => $key,
		'value' => $this->request->query($key)
	];
	$options = array_merge($options, $filter);

	// Filter class
	$options['div'] = 'filter' . (isset($options['div']) ? ' ' . $options['div'] : '');

	// Labels
	if (!$labels) {
		$options['label'] = false;
	}

	if (!empty($options['advanced']) && !$advanced) {
		$options['type'] = 'hidden';
	}

	// Settings per input type
	if ($options['type'] == 'select') {
		// Select
		if (!isset($options['empty'])) {
			$options['empty'] = __('Todos');
		}
	} elseif ($options['type'] == 'date') {
		// Date
		$options['size'] = 12;
	}

	echo $this->BootForm->input($key, $options);
}
?>
