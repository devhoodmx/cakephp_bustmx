<?php
$attrs = [
	'data-component' => 'properties-plan'
];
$opts = [
	'key',
	'areas'
];
$class = sprintf('properties-plan-component%s', (empty($class) ?  '' : ' ' . $class));

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

		$attrs[$attrKey] = $attrValue;
	}
}

// Load assets
$this->Package->append('component', 'css', array(
	'component.properties-plan'
));
$this->Package->append('component', 'js', array(
	'component.properties-plan'
));
?>

<?php
// Set data
if (!empty($properties)):
?>
<?php $this->append('script'); ?>
<script>
	hozen.data.component['properties-plan'] = hozen.data.component['properties-plan'] ? hozen.data.component['properties-plan'] : {};
	hozen.data.component['properties-plan']['<?php echo $key; ?>'] = {
		properties: <?php echo json_encode($properties); ?>
	};
</script>
<?php $this->end(); ?>
<?php endif; ?>

<?php echo $this->Html->div($class, null, $attrs); ?>
	<?php
	echo $this->Html->image(
		$plan,
		[
			'class' => 'properties-plan img-fluid',
			'alt' => 'Plan'
		]
	);
	?>

	<div class='properties-areas'></div>
</div>
