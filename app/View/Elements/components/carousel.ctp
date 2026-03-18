<?php
// Requires script vendor.bootstrap-4.carousel
$id = empty($id) ? 'carousel-' . mt_rand(0, 1000) : $id;
$class = sprintf('carousel-component carousel slide%s', (empty($class) ?  '' : ' ' . $class));
$controls = isset($controls) ? $controls : true;
$indicators = isset($indicators) ? $indicators : true;
$layout = isset($layout) ? $layout : null;
$attrs = array(
	'id' => $id,
	'data-ride' => 'carousel',
	'data-pause' => 'hover'
);
$size = sizeof($items);
$counter = 0;

if (isset($interval)) {
	$attrs['data-interval'] = $interval;
}

// Layout
if ($layout == 'cover') {
	$class .= ' cover';
}

$this->Package->append('component', 'css', array(
	'component.carousel'
));
?>
<?php if ($size > 0): ?>
<!-- Carousel -->
<?php echo $this->Html->div($class, null, $attrs); ?>
	<?php if ($indicators && $size > 1): ?>
	<!-- Indicators -->
	<ol class='carousel-indicators'>
		<?php
		foreach ($items as $key => $item):
			$class = $counter == 0 ? 'active' : '';
		?>
		<li
			data-target='#<?php echo $id; ?>'
			data-slide-to='<?php echo $counter++; ?>'
			class='<?php echo $class; ?>'
		>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>

	<!-- Slides -->
	<div class='carousel-inner'>
		<?php
		$counter = 0;

		foreach ($items as $key => $item):
			$class = 'carousel-item';
			$class .= $counter++ == 0 ? ' active' : '';
			$attrs = [];
			$styles = [];
			$type = empty($item['type']) ? 'image' : $item['type'];

			// Class
			if (!empty($item['class'])) {
				$class .= ' ' . $item['class'];
			}
			// Source
			if (!empty($item['source'])) {
				if (!is_array($item['source'])) {
					$item['source'] = [
						'url' => $item['source']
					];
				}
			}
			// Styles
			if ($layout == 'cover' && $type == 'image') {
				$styles[] = sprintf("background-image: url('%s');", $item['source']['url']);
			}
			// Attributes
			if (!empty($styles)) {
				$attrs['style'] = implode(' ', $styles);
			}
		?>
		<?php echo $this->Html->div($class, null, $attrs); ?>
			<?php
			if (!empty($item['contain'])) {
				$class = sprintf('container%s', (empty($item['contain']['class']) ?  '' : ' ' . $item['contain']['class']));

				printf("<div class='%s'>", $class);
			}
			?>

			<?php if (!empty($item['content'])): ?>

			<?php echo $item['content']; ?>

			<?php else: ?>

			<?php if ($type == 'image'): ?>
			<!-- Image -->
			<?php
			$_opts = $item['source'];

			unset($_opts['url']);
			$_opts['class'] = sprintf('carousel-image%s', (empty($_opts['class']) ?  '' : ' ' . $_opts['class']));

			echo $this->Html->image($item['source']['url'], $_opts);
			?>

			<?php if (!empty($item['title']) || !empty($item['description'])): ?>
			<div class='carousel-caption'>
				<?php if (!empty($item['title'])): ?>
				<h5 class='carousel-title'><?php echo $item['title']; ?></h5>
				<?php endif; ?>

				<?php if (!empty($item['description'])): ?>
				<p class='carousel-description'><?php echo $item['description']; ?></p>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php elseif ($type == 'video'): ?>
			<!-- Video -->
			<?php
			$_opts = array(
				'source' => $item['source']['url'],
				'class' => 'carousel-video'
			);

			if (!empty($item['source']['class'])) {
				$_opts['class'] .= ' ' . $item['source']['class'];
			}

			echo $this->element('components/video', $_opts);
			?>
			<?php endif; ?>

			<?php endif; ?>

			<?php
			if (!empty($item['contain'])) {
				printf('</div>');
			}
			?>
		</div>
		<?php endforeach; ?>
	</div>

	<?php if ($controls && $size > 1): ?>
	<!-- Controls -->
	<a class='carousel-control-prev' href='#<?php echo $id; ?>' role='button' data-slide='prev'>
		<span class='carousel-control-prev-icon' aria-hidden='true'></span>
		<span class='sr-only'><?php echo __('Anterior'); ?></span>
	</a>

	<a class='carousel-control-next' href='#<?php echo $id; ?>' role='button' data-slide='next'>
		<span class='carousel-control-next-icon' aria-hidden='true'></span>
		<span class='sr-only'><?php echo __('Siguiente'); ?></span>
	</a>
	<?php endif; ?>
</div>
<?php endif; ?>
