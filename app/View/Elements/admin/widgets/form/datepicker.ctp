<?php
$valid = array('label', 'value', 'after', 'error', 'size', 'mode', 'icon');
$options = array();
$field = empty($field) ? 'date' : $field;
$date = !empty($this->request->data[$model][$field]) ? $this->request->data[$model][$field] : NULL;

// Load locales
if ($locale !== 'en') {
	$this->Package->append('view', 'js', array(
		'vendor.bootstrap-datepicker.locales.' . $locale
	));
}

// Options
foreach ($valid as $opt) {
	if (isset($$opt)) {
		$options[$opt] = $$opt;
	}
}
$options = array_merge($options, array(
	'type' => 'date',
	'format' => $dateConfig[$model][$field . '_format'],
	'date' => $date,
	'language' => $locale,
	'startDate' => isset($startDate) ? $startDate : null,
	'endDate' => isset($endDate) ? $endDate : null,
	'calendarWeeks' => isset($calendarWeeks) ? $calendarWeeks : null,
));

echo $this->BootForm->input($model . '.' . $field, $options);
