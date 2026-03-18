<?php
$id = !empty($id) ? $id : null;
$class = sprintf('inputs-component%s', (empty($class) ?  '' : ' ' . $class));
$fake = !empty($fake);
$attrs = [];

if ($id) {
	$attrs['id'] = $id;
}

$this->Package->append('component', 'css', array(
	'component.inputs'
));
?>
<?php echo $this->Html->div($class, null, $attrs); ?>
	<?php
	foreach ($inputs as $key => $input):
		$class = sprintf(
			'input-item %s-item',
			Utility::slug(Inflector::underscore($key))
		);
		$opts = $input;

		if ($fake && isset($opts['fake']) && $opts['fake'] !== false) {
			$opts['default'] = $opts['fake'];
			unset($opts['fake']);
		}
	?>
	<div class='<?php echo $class; ?>'>
		<?php echo $this->BootForm->input($key, $opts); ?>
	</div>
	<?php endforeach; ?>
</div>
