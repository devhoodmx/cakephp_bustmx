<div
	data-model='WebPageSection'
	data-sortable
	data-id='<?php echo !empty($section['id']) ? $section['id'] : '' ?>'
	data-url='/admin/web_page_sections'
>
	<div class='webpage-intent'>
		<div class='btn-group'>
			<a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
				<i class='fas fa-plus'></i> <span class='btn-title'><?php echo __('Agregar sección'); ?></span>
			</a>

			<ul class='dropdown-menu text-left'>
				<?php
				$columnNames = array(
					1 => '1 Columna',
					'2 Columnas (50% - 50%)',
					'3 Columnas (33% - 33% - 33%)',
					'4 Columnas (25% - 25% - 25% - 25%)',
					'2 Columnas (60% - 40%)',
					'2 Columnas (40% - 60%)'
				);
				for ($i = 1; $i <= 6; $i++) :
				?>
				<li>
					<?php
					echo $this->Html->link(
						$columnNames[$i],
						array(
							'controller' => 'web_page_sections',
							'action' => 'add',
							$page['id'],
							$i,
							isset($section) ? $section['id'] : null
						),
						array(
							'escape' => false
						)
					);
					?>
				</li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>

	<?php if (isset($section)): ?>
	<?php
	$class = 'webpage-section webpage-unit';
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
			"background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.5) 0%%, rgba(255, 255, 255, 0.5) 100%%), url('%s'); background-position: center; background-size: cover;",
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
		<!-- Actions -->
		<div class='webpage-actions'>
			<div class='btn-group'>
				<?php
				if (!empty($section['MediaBackground'])) {
					echo '<i class="fas fa-picture"></i>';
				}
				?>
			</div>

			<div class='btn-group'>
				<?php
				if (!empty($section)) {
					echo $this->Html->link(
						'<i class="fas fa-cog"></i>',
						array('controller' => 'web_page_sections', 'action' => 'edit', $section['id']),
						array(
							'class' => 'btn btn-sm btn-warning',
							'escape' => false
						)
					);

					echo $this->Html->link(
						"<i class='far fa-trash-alt'></i>",
						'#',
						array(
							'escape' => false,
							'class' => 'btn btn-sm btn-danger',
							'data-delete',
							'data-dialog' => __('delete-dialog'),
							'data-redirect' => $this->Html->url(array('action' => 'index')),
							'data-model' => 'WebPageSection',
							'data-id' => $section['id'],
							'data-name' => $section['name'],
							'data-url' => '/admin/web_page_sections'
						)
					);
				}
				?>
			</div>
		</div>

		<!-- Columns -->
		<div class='row'>
			<?php
			for ($i = 1; $i <= $section['columns']; $i++):
				$columnClass = 'col-md-';
				if ($section['layout'] <= 4) {
					$columnClass .= 12/$section['columns'];
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
				<div data-sortable-container>
					<?php
					foreach($section['Column' . $i] as $key => $element) {
						if ($key > 0 &&
							isset($section['Column' . $i][$key - 1]['wrap']) &&
							$section['Column' . $i][$key - 1]['wrap'] &&
							!in_array($element['type'], array('Contact','Login','Map')))
						{
							$contains = true;
						} else {
							$contains = false;
						}

						if (($key > 0 &&
							isset($section['Column' . $i][$key - 1]['wrap'])) &&
							isset($element['wrap'])) {
								$contains = false;
						}

						echo $this->element('admin/web_pages/element', array(
							'section' => $section,
							'column' => $i,
							'element' => $element,
							'contains' => $contains
						));
					}

					// Empty to add more elements
					echo $this->element('admin/web_pages/element', array(
						'section' => $section,
						'column' => $i
					));
					?>
				</div>

			</div>
			<?php endfor; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
