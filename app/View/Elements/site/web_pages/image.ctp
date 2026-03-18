<?php
if (!empty($element['MediaImage'])):
	$imageCount = sizeof($element['MediaImage']);

	if ($imageCount > 1):
?>
<!-- Carousel -->
<?php
$items = [];

if (!empty($element['MediaImage'])) {
	foreach ($element['MediaImage'] as $key => $image) {
		$items[$image['id']] = [
			'id' => $image['id'],
			'source' => [
				'url' => sprintf(
					'/files/media/image/element_%s.%s',
					$image['key'],
					$image['format']
				),
				'class' => 'd-block w-100',
				'alt' => $image['alt']
			],
			'title' => $image['title'],
			'description' => $image['subtitle'],
			'width' => $image['width'],
			'height' => $image['height']
		];
	}
}

if (!empty($items)) {
	echo $this->element('components/carousel', [
		'id' => 'carousel-' . $element['id'],
		'class' => 'webpage-carousel webpage-element',
		'items' => $items
	]);
}
?>
<?php else: ?>
<!-- Image -->
<div class='webpage-element webpage-image <?php echo $element['align']; ?>'>
	<?php
	$image = $element['MediaImage'][0];
	$imagePath = sprintf(
		'/files/media/image/element_%s.%s',
		$image['key'],
		$image['format']
	);
	$opts = ['alt' => $image['alt']];
	$html = $this->Html->image($imagePath, $opts);

	if (!empty($element['url'])) {
		$html = $this->Html->link(
			$html,
			$element['url'],
			array(
				'escape' => false
			)
		);
	}

	echo $html;
	?>

	<?php if (!empty($image['title']) || !empty($image['subtitle'])): ?>
	<div class='caption d-none d-md-block'>
		<?php if (!empty($image['title'])): ?>
		<h5><?php echo $image['title']; ?></h5>
		<?php endif; ?>

		<?php if (!empty($image['subtitle'])): ?>
		<p><?php echo $image['subtitle']; ?></p>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<?php
	endif;
endif;
?>

<?php if (!$element['wrap']) : ?>
<div class='clearfix'></div>
<?php endif; ?>
