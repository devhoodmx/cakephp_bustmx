<?php
$id = empty($id) ? '' : $id;
$class = sprintf('breadcrumb-component%s', (empty($class) ?  '' : ' ' . $class));
$counter = 1;
$size = sizeof($items);
$current = isset($current) ? $current : true;
?>
<?php if (!empty($items)): ?>
<nav <?php $id ? printf("id='%s'", $id) : ''; ?> aria-label='breadcrumb' class='<?php echo $class; ?>'>
	<ol class='breadcrumb'>
		<?php
		foreach ($items as $key => $item):
			$class = 'breadcrumb-item';
			$active = false;

			if ($counter++ == $size && $current) {
				$class .= ' active';
				$active = true;
			}
		?>
		<li
			class='<?php echo $class; ?>'
			<?php echo ($active ? "aria-current='page'" : ''); ?>
		>
			<?php
			if ($active) {
				echo $item['name'];
			} else {
				echo $this->Html->link(
					$item['name'],
					$item['url'],
					array(
						'escape' => false,
						'class' => 'breadcrumb-link'
					)
				);
			}
			?>
		</li>
		<?php endforeach; ?>
	</ol>
</nav>
<?php endif; ?>
