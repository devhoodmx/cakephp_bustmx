<?php
$attrs = [
	'data-component' => 'dropdown'
];
$class = sprintf('dropdown-component%s', (empty($class) ?  '' : ' ' . $class));
$toggle = !empty($toggle) ? $toggle : null;
$items = isset($items) && is_array($items) ? $items : [];
$active = isset($active) ? $active : null;

$toggleDefaults = [
	'title' => '',
	'class' => ''
];

// Id
if (isset($id)) {
	$attrs['id'] = $id;
}

// Toggle
if (isset($items[$active])) {
	$toggleDefaults['title'] = $items[$active]['name'];
}
if ($toggle) {
	$buffer = $toggleDefaults;

	if (is_array($toggle)) {
		$buffer = array_merge($buffer, $toggle);
	} else {
		$buffer['title'] = $toggle;
	}
	$toggle = $buffer;
} elseif (isset($items[$active])) {
	$toggle = $toggleDefaults;
}
?>
<?php echo $this->Html->div($class, null, $attrs); ?>
	<?php if ($toggle): ?>
	<?php
	$_class = 'btn dropdown-toggle';
	$_length = 10;
	// See https://github.com/cakephp/cakephp/blob/3.8.7/src/Utility/Security.php#L143
	$_id = sprintf(
		'dropdown-toggle-%s',
		substr(
			bin2hex(Security::randomBytes((int)ceil($_length / 2))),
			0,
			$_length
		)
	);


	if ($toggle['class']) {
		$_class .= ' ' . $toggle['class'];
	}
	?>
	<button id='<?php echo $_id; ?>' class='<?php echo $_class; ?>' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
		<span class='dropdown-toggle-title'><?php echo $toggle['title']; ?></span>
	</button>
	<?php endif; ?>

	<?php if (!empty($items)): ?>
	<div class='dropdown-menu' aria-labelledby='<?php echo $_id; ?>'>
		<?php
		foreach ($items as $key => $item):
			$_class = 'dropdown-item';

			// Class
			if (!empty($item['class'])) {
				$_class .= ' ' . $item['class'];
			}
			// Active
			if ($active != null && $key == $active) {
				$_class .= ' active';
			}
		?>
		<?php
		echo $this->Html->link(
			$item['name'],
			$item['url'],
			[
				'escape' => false,
				'class' => $_class
			]
		);
		?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
