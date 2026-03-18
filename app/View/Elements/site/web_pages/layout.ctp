<?php
if (!empty($page['WebPageSection'])) :
	$totalColumns = 12;

	foreach ($page['WebPageSection'] as $sectionKey => $section) :
?>
<?php
$class = 'webpage-section';
$styles = array();
$options = array(
	'id' => 'webpage-section-' . $section['id']
);

// Center content
if ($section['centered']) {
	$class .= ' centered';
}
// Min height
if (!empty($section['min_height'])) {
	$styles[] = sprintf(
		'min-height: %s;',
		$section['min_height']
	);
}
// Add margin bottom
if ($section['spaced']) {
	$class .= ' spaced';
}
// Top & bottom padding
if ($section['padded']) {
	$class .= ' padded';
}
// Background color
if (!empty($section['background_color'])) {
	$styles[] = sprintf(
		'background-color: %s;',
		$section['background_color']
	);
}
// Background image
if (!empty($section['MediaBackground']['id'])) {
	$imagePath = sprintf(
		'/files/media/image/background_%s.%s',
		$section['MediaBackground']['key'],
		$section['MediaBackground']['format']
	);
	$styles[] = sprintf(
		"background-image: url('%s'); background-position: center; background-size: cover;",
		$imagePath
	);
}
// Inline styles
if (!empty($section['styles'])) {
	$buffer = preg_replace('/(\r|\n| {2,})/', '', $section['styles']);

	if (!empty($buffer)) {
		$styles[] = $buffer;
	}
}
// Class
if (!empty($section['class'])) {
	$class .= ' ' . $section['class'];
}

if (!empty($styles)) {
	$options['style'] = implode(' ', $styles);
}

echo $this->Html->div($class, null, $options);
?>
	<?php
	$class = 'container-fluid';

	if ($section['centered']) {
		$class = 'container';
	}
	?>
	<div class='<?php echo $class; ?>'>
		<div class='row'>
			<?php
			$offsetClass = 'col-md-12';
			if ($section['offset']) {
				$offsetClass = 'col-md-10 offset-md-1';
			}
			?>
			<div class='<?php echo $offsetClass; ?>'>
				<div class='row'>
					<?php
					for ($i = 1; $i <= $section['columns']; $i++):
						$columnClass = 'col-md-';
						if ($section['layout'] <= 4) {
							$columnClass .= floor($totalColumns / $section['columns']);
						} elseif ($section['layout'] == 5) {
							if  ($i == 1) {
								$columnClass .= '7';
							} else {
								$columnClass .= '5';
							}
						} elseif ($section['layout'] == 6) {
							if  ($i == 1) {
								$columnClass .= '5';
							} else {
								$columnClass .= '7';
							}
						}
					?>

					<div class='webpage-column <?php echo $columnClass; ?>'>
						<?php
						foreach ($section['Column' . $i] as $key => $element):
							echo $this->element('site/web_pages/' . strtolower($element['type']), array(
								'element' => $element
							));
						?>
						<?php endforeach; ?>
					</div>

					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	endforeach;
endif;
?>
