<?php
$imageCount = sizeof($element['MediaImage']);
$filePrefix = isset($filePrefix) ? $filePrefix : 'car_';
?>
<div class='webpage-content <?php echo $imageCount > 1 ? 'img-thumbnail' : '' ?>'>
	<?php if ($imageCount == 1) : ?>
	<?php
	$image = $this->Html->image(
		'/files/media/image/' . $filePrefix . $element['MediaImage']['0']['key'] . '.' . $element['MediaImage']['0']['format'],
		array('class' => 'img-thumbnail')
	);
	echo $this->Html->link(
		$image,
		array(
			'controller' => 'images',
			'action' => 'add',
			$element['id']
		),
		array('escape' => false)
	);
	?>
	<?php else: ?>
	<div id='carousel-<?php echo $element['id']; ?>' class='carousel slide' data-pause='hover' data-wrap>
		<!-- Indicators -->
		<ol class='carousel-indicators'>
			<?php
			foreach ($element['MediaImage'] as $imageIndicatorKey => $imageIndicator) :
				$imageIndicatorClass = $imageIndicatorKey == 0 ? 'active' : '';
			?>
			<li
				data-target='#carousel-<?php echo $element['id'] ?>'
				data-slide-to='<?php echo $imageIndicatorKey ?>'
				class='<?php echo $imageIndicatorClass ?>'
			>
			</li>
			<?php endforeach; ?>
		</ol>

		<!-- Wrapper for slides -->
		<div class='carousel-inner' role='listbox'>
			<?php
			foreach ($element['MediaImage'] as $imageKey => $image) :
				$imageClass = $imageKey == 0 ? 'active' : '';
			?>
			<div class='item <?php echo $imageClass ?>'>
				<?php
				$displayImage = $this->Html->image(
					'/files/media/image/' . $filePrefix . $image['key'] . '.' . $image['format']
				);
				echo $this->Html->link(
					$displayImage,
					array(
						'controller' => 'images',
						'action' => 'add',
						$element['id']
					),
					array('escape' => false)
				);
				?>

				<?php if ($image['title']) : ?>
				<div class='carousel-caption'>
					<h3><?php echo $image['title'] ?></h3>
					<p><?php echo $image['subtitle'] ?></p>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>

		<!-- Controls -->
		<a class='left carousel-control' href='#carousel-<?php echo $element['id']?>' role='button' data-slide='prev'>
			<i class='fas fa-chevron-left glyphicon-chevron-left' aria-hidden='true'></i>
		</a>
		<a class='right carousel-control' href='#carousel-<?php echo $element['id']?>' role='button' data-slide='next'>
			<span class='fas fa-chevron-right glyphicon-chevron-right' aria-hidden='true'></span>
		</a>
	</div>
	<?php endif; ?>
</div>
