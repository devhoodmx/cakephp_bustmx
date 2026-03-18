<?php
$attrs = array(
	'data-component' => 'map'
);
$class = sprintf('map-component%s', (empty($class) ?  '' : ' ' . $class));
$opts = [
	'key',
	'latitude',
	'longitude',
	'zoom',
	'icon',
	'width',
	'height',
	'controls',
	'type'
];
$serviceKey = Configure::read('App.services.google-maps.api-key');

// Id
if (isset($id)) {
	$attrs['id'] = $id;
}

// Key
if (!isset($key)) {
	// See https://github.com/cakephp/cakephp/blob/3.8.7/src/Utility/Security.php#L143
	$_length = 10;
	$key = substr(
		bin2hex(Security::randomBytes((int)ceil($_length / 2))),
		0,
		$_length
	);
}

// Data
foreach ($opts as $opt) {
	if (isset($$opt)) {
		$optKey = str_replace('_', '-', Inflector::underscore($opt));
		$attrKey= sprintf('data-%s', $optKey);
		$attrValue = $$opt;

		if (in_array($optKey, ['controls']) && is_array($attrValue)) {
			$attrValue = json_encode($attrValue);
		}

		$attrs[$attrKey] = $attrValue;
	}
}
?>

<?php if (!empty($serviceKey)): ?>
<?php
// Load scripts
$url = sprintf(
	'https://maps.googleapis.com/maps/api/js?key=%s&callback=%s',
	$serviceKey,
	'onMapLoaded'
);

$this->Package->append('view', 'js', array(
	'component.map'
));
echo $this->Html->script($url, array('block' => 'posscript', 'defer' => true, 'async' => true, 'inline' => false));
?>

<?php
// Set data
if (!empty($locations)):
?>
<?php $this->append('script'); ?>
<script>
	hozen.data.component.map = hozen.data.component.map ? hozen.data.component.map : {};
	hozen.data.component.map['<?php echo $key; ?>'] = {
		locations: <?php echo json_encode($locations); ?>
	};
</script>
<?php $this->end(); ?>
<?php endif; ?>

<?php
// Render component
echo $this->Html->div($class, '', $attrs);
?>

<?php endif; ?>
