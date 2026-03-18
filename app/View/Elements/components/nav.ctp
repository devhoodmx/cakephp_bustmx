<?php
$attrs = [];
$level = isset($level) ? $level : 1;
$class = sprintf('nav-component nav-list nav-level-%s%s', $level, (empty($class) ?  '' : ' ' . $class));
$separator = isset($separator) ? $separator : '';
$toggle = isset($toggle) ? $toggle : '';
$depth = isset($depth) ? $depth : 2;
$active = isset($active) ? $active : null;

// Top level
if ($level === 1) {
	$attrs['data-component'] = 'nav';

	// Id
	if (!empty($id)) {
		$attrs['id'] = $id;
	}
	// Class
	$class = 'navbar-nav ' . $class;
	// Separator
	if (!empty($separator)) {
		$class .= ' separator';
	}
	// Track
	$attrs['data-track'] = empty($track) ? 'false' : 'true';
	// Active item
	if ($active === null) {
		if ($this->fetch('navItemKey')) {
			$active = $this->fetch('navItemKey');
		} elseif ($this->fetch('menuItemKey')) {
			$active = $this->fetch('menuItemKey');
		}
	}
}

// Toggle
if ($toggle == 'dropdown' && $level > 1) {
	$class .= ' dropdown-menu';
}

// Attributes
$attrs['class'] = $class;
?>

<?php if (!empty($items)): ?>
<?php echo $this->Html->tag('ul', null, $attrs); ?>
	<?php
	foreach ($items as $key => $item):
		$attrs = [
			'class' => 'nav-item'
		];

		// Class
		if ($key === $active) {
			$attrs['class'] .= ' active';
		}
		// Separator
		if (!empty($separator)) {
			$attrs['data-separator'] = $separator;
		}
		// Toggle
		if ($toggle == 'dropdown' && !empty($item['children'])) {
			$attrs['class'] .= ' dropdown';
		}
	?>
	<?php echo $this->Html->tag('li', null, $attrs); ?>
		<?php
		$opts = array(
			'class' => 'nav-link nav-option',
			'escape' => false
		);
		$name = '';

		// Name
		if (!empty($item['name'])) {
			$name = $item['name'];
		}
		// Icon
		if (!empty($item['icon'])) {
			$name = sprintf(
				"<i class='nav-icon %s'></i> %s",
				$item['icon'],
				$name
			);
		}
		// Toggle
		if ($toggle == 'dropdown' && !empty($item['children'])) {
			$opts['class'] .= ' dropdown-toggle';
			$opts['data-toggle'] = 'dropdown';
		}
		// Class
		if (!empty($item['class'])) {
			$opts['class'] .= ' ' . $item['class'];
		}
		// Target
		if (!empty($item['target'])) {
			$opts['target'] = $item['target'];
		}

		echo $this->Html->link(
			$name,
			$item['url'],
			$opts
		);
		?>

		<?php
		// Children
		if (!empty($item['children']) && $level <= $depth) {
			$opts = [
				'level' => $level + 1,
				'toggle' => $toggle,
				'depth' => $depth,
				'items' => $item['children'],
				'active' => $active
			];

			echo $this->element('components/nav', $opts);
		}
		?>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
