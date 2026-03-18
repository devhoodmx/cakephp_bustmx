<?php
$attrs = array(
	'data-component' => 'hubspot-form'
);
$class = sprintf('hubspot-form-component%s', (empty($class) ?  '' : ' ' . $class));
$opts = [
	'portalId',
	'formId'
];

// Id
if (isset($id)) {
	$attrs['id'] = $id;
}

// Portal Id
if (!isset($portalId) && !empty(Configure::read('App.services.hubspot.portal-id'))) {
	$portalId = Configure::read('App.services.hubspot.portal-id');
}

// Data
foreach ($opts as $opt) {
	if (isset($$opt)) {
		$optKey = str_replace('_', '-', Inflector::underscore($opt));
		$attrKey= sprintf('data-%s', $optKey);
		$attrValue = $$opt;

		$attrs[$attrKey] = $attrValue;
	}
}
?>
<?php echo $this->Html->div($class, '', $attrs); ?>
