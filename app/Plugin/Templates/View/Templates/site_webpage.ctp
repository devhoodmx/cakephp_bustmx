<?php
$this->Package->assign('vendor', 'js', array(
	'vendor.bootstrap.carousel'
));
$this->Package->assign('view', 'js', array(
	//'app.pages.template'
));
$this->Package->assign('view', 'css', array(
	'site.component.font-awesome',
	'site.core.webpage'
));

// Page properties
$this->assign('title', __('page-title', __('Webpage'), __('Site')));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<?php
$carouselId = 'webpage-main-carousel';
$carouselSize = 3;
?>
<div id='<?php echo $carouselId; ?>' class='carousel slide webpage-main-carousel' data-ride='carousel'>
	<?php if ($carouselSize > 1): ?>
	<!-- Indicators -->
	<ol class='carousel-indicators'>
		<?php for ($index = 0; $index < $carouselSize; $index++): ?>
		<li
			data-target='#<?php echo $carouselId; ?>'
			data-slide-to='<?php echo $index; ?>'
			class='<?php echo !$index ? 'active' : ''; ?>'
		>
		</li>
		<?php endfor; ?>
	</ol>
	<?php endif; ?>

	<div class='carousel-inner' role='listbox'>
		<?php
		for ($index = 0; $index < $carouselSize; $index++):
		$image = sprintf('https://unsplash.it/1200/675?image=%s', $index + 10);
		?>
		<div class='item <?php echo !$index ? 'active' : ''; ?>' style='background-image: url(<?php echo $image; ?>);'>
			<?php
			echo $this->Html->image(
				$image,
				array(
					'alt' => ''
				)
			);
			?>

			<div class='carousel-caption'>
				<h3>Title</h3>

				<p>Lorem ipsum lectus sem fermentum vitae Quisque quis, tempus, urna at Donec vitae. Tempor imperdiet felis eu id ullamcorper. Curabitur dolor lorem.</p>

				<?php
				echo $this->Html->link(
					__('Call to action'),
					array('controller' => 'pages', 'action' => 'home'),
					array(
						'class' => 'btn btn-default',
						'escape' => false
					)
				);
				?>
			</div>
		</div>
		<?php endfor; ?>
	</div>

	<?php if ($carouselSize > 1): ?>
	<!-- Controls -->
	<a class='left carousel-control' href='#<?php echo $carouselId; ?>' role='button' data-slide='prev'>
		<span class='glyphicon-chevron-left fas fa-chevron-left' aria-hidden='true'></span>
		<span class='sr-only'><?php echo __('Anterior'); ?></span>
	</a>

	<a class='right carousel-control' href='#<?php echo $carouselId; ?>' role='button' data-slide='next'>
		<span class='glyphicon-chevron-right fas fa-chevron-right' aria-hidden='true'></span>
		<span class='sr-only'><?php echo __('Siguiente'); ?></span>
	</a>
	<?php endif; ?>
</div>

<div class='webpage'>
	<div class='container'>
		<div class='webpage-section spaced row'>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='webpage-column col-sm-12'>
						<div class='webpage-element webpage-text'>
							<h1>Heading 1</h1>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='webpage-section spaced row'>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='webpage-column col-sm-6'>
						<div class='webpage-element webpage-text'>
							<h2>1/2</h2>
						</div>

						<div class='webpage-element webpage-image fluid'>
							<?php echo $this->Html->image('http://placehold.it/240x135'); ?>
						</div>

						<div class='webpage-element webpage-text'>
							<?php for($index = 0; $index < 6; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-6'>
						<div class='webpage-element webpage-text'>
							<h2>1/2</h2>
						</div>

						<div class='webpage-element webpage-image right'>
							<?php echo $this->Html->image('http://placehold.it/240x135'); ?>
						</div>

						<div class='webpage-element webpage-text'>
							<?php for($index = 0; $index < 2; $index++): ?>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>

						<div class='clearfix'></div>

						<div class='webpage-element webpage-image left'>
							<?php echo $this->Html->image('http://placehold.it/240x135'); ?>
						</div>

						<div class='webpage-element webpage-text'>
							<?php for($index = 0; $index < 2; $index++): ?>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>

						<div class='clearfix'></div>

						<div class='webpage-element webpage-image center'>
							<?php echo $this->Html->image('http://placehold.it/240x135'); ?>
						</div>

						<div class='webpage-element webpage-text'>
							<?php for($index = 0; $index < 2; $index++): ?>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='webpage-section spaced row'>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='webpage-column col-sm-4'>
						<div class='webpage-element webpage-text'>
							<h2>1/3</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-4'>
						<div class='webpage-element webpage-text'>
							<h2>1/3</h2>
						</div>

						<div class='webpage-element webpage-video fluid embed-responsive embed-responsive-16by9'>
							<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/ct_54shfkuA?rel=0' allowfullscreen></iframe>
						</div>

						<div class='webpage-element webpage-text'>
							<?php for($index = 0; $index < 1; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-4'>
						<div class='webpage-element webpage-text'>
							<h2>1/3</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='webpage-section spaced row'>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='webpage-column col-sm-3'>
						<div class='webpage-element webpage-text'>
							<h2>1/4</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-3'>
						<div class='webpage-element webpage-text'>
							<h2>1/4</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-3'>
						<div class='webpage-element webpage-text'>
							<h2>1/4</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-3'>
						<div class='webpage-element webpage-text'>
							<h2>1/4</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='webpage-section spaced row'>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='webpage-column col-sm-4'>
						<div class='webpage-element webpage-text'>
							<h2>1/3</h2>

							<?php for($index = 0; $index < 1; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-8'>
						<div class='webpage-element webpage-text'>
							<h2>2/3</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='webpage-section row'>
			<div class='col-sm-10 col-sm-offset-1'>
				<div class='row'>
					<div class='webpage-column col-sm-8'>
						<div class='webpage-element webpage-text'>
							<h2>2/3</h2>

							<?php for($index = 0; $index < 2; $index++): ?>
							<p><strong>I'm not spaced</strong>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>

					<div class='webpage-column col-sm-4'>
						<div class='webpage-element webpage-text'>
							<h2>1/3</h2>

							<?php for($index = 0; $index < 1; $index++): ?>
							<p><strong>I'm not spaced</strong>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='webpage-section row'>
			<div class='col-sm-10 col-sm-offset-1'>
				<div class='row'>
					<div class='webpage-column col-sm-12'>
						<div class='webpage-element webpage-text'>
							<?php for($index = 0; $index < 2; $index++): ?>
							<p><strong>I'm not spaced</strong>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
