<?php
$attrs = '';
if (!empty($element)) {
	$attrs .= sprintf(
		"id='webpage-element-%s' data-id='%s' data-model='WebPageElement' data-name='%s' data-url='%s'",
		$element['id'],
		$element['id'],
		$element['name'],
		'/admin/web_page_elements'
	);
}
?>
<div <?php echo $attrs; ?>>
	<!-- Tools -->
    <?php if (!isset($contains) || !$contains) : ?>
    <div class='webpage-break'></div>

	<div class='webpage-intent'>
		<div class='btn-group'>
			<a href='#' class='btn btn-default btn-sm dropdown-toggle' data-toggle='dropdown'>
				<i class='fas fa-plus'></i> <span class='btn-title'><?php echo __('Agregar elemento'); ?></span>
			</a>

			<ul class='dropdown-menu text-left'>
				<li>
					<?php
					// Text
					echo $this->Html->link(
						'<i class="fas fa-font fa-fw"></i> Texto',
						array(
							'controller' => 'web_page_elements',
							'action' => 'add',
							$section['id'],
							$column,
							'Text',
							isset($element) ? $element['id'] : null
						),
						array('escape' => false)
					);
					?>
				</li>
				<li>
					<?php
					echo $this->Html->link(
						'<i class="far fa-image fa-fw"></i> Imágenes',
						array(
							'controller' => 'web_page_elements',
							'action' => 'add',
							$section['id'],
							$column,
							'Image',
							isset($element) ? $element['id'] : null
						),
						array('escape' => false)
					);
					?>
				</li>
				<li>
					<?php
					// Video
					echo $this->Html->link(
						'<i class="fab fa-youtube fa-fw"></i> Video',
						array(
							'controller' => 'web_page_elements',
							'action' => 'add',
							$section['id'],
							$column,
							'Video',
							isset($element) ? $element['id'] : null
						),
						array('escape' => false)
					);
					?>
				</li>
				<li>
					<?php
					// File
					echo $this->Html->link(
						'<i class="fas fa-file fa-fw"></i> Archivos',
						array(
							'controller' => 'web_page_elements',
							'action' => 'add',
							$section['id'],
							$column,
							'Archive',
							isset($element) ? $element['id'] : null
						),
						array('escape' => false)
					);
					?>
				</li>
				<li>
					<?php
					// Code
					echo $this->Html->link(
						'<i class="fas fa-code fa-fw"></i> Código',
						array(
							'controller' => 'web_page_elements',
							'action' => 'add',
							$section['id'],
							$column,
							'Code',
							isset($element) ? $element['id'] : null
						),
						array('escape' => false)
					);
					?>
				</li>

				<li>
					<?php
					// Map
					echo $this->Html->link(
						'<i class="fas fa-map-marked fa-fw"></i> Mapa',
						array(
							'controller' => 'web_page_elements',
							'action' => 'add',
							$section['id'],
							$column,
							'Map',
							isset($element) ? $element['id'] : null
						),
						array('escape' => false)
					);
					?>
				</li>
			</ul>
			<?php
			/*/ Contact
			echo $this->Html->link(
				$this->Html->image('admin/layout/element-contact.png', array(
					'title' => 'Forma de Contacto'
				)),
				array(
					'controller' => 'web_page_elements',
					'action' => 'add',
					$section['id'],
					$column,
					'Contact',
					isset($element) ? $element['id'] : null
				),
				null, false, false
			);
			// Login
			echo $this->Html->link(
				$this->Html->image('admin/layout/element-login.png', array(
					'title' => 'Login de Estudiantes'
				)),
				array(
					'controller' => 'web_page_elements',
					'action' => 'add',
					$section['id'],
					$column,
					'Login',
					isset($element) ? $element['id'] : null
				),
				null, false, false
			);
			// Gallery
			echo $this->Html->link(
				$this->Html->image('admin/layout/gallery.png', array(
					'title' => 'Galería'
				)),
				array(
					'controller' => 'web_page_elements',
					'action' => 'add',
					$section['id'],
					$column,
					'Gallery',
					isset($element) ? $element['id'] : null
				),
				null, false, false
			);
			// Flash
			echo $this->Html->link(
				$this->Html->image('admin/layout/flash.png', array(
					'title' => 'Flash'
				)),
				array(
					'controller' => 'web_page_elements',
					'action' => 'add',
					$section['id'],
					$column,
					'Flash',
					isset($element) ? $element['id'] : null
				),
				null, false, false
			);
			// Question
			echo $this->Html->link(
				$this->Html->image('admin/layout/question.png', array(
					'title' => 'Pregunta'
				)),
				array(
					'controller' => 'web_page_elements',
					'action' => 'add',
					$section['id'],
					$column,
					'Question',
					isset($element) ? $element['id'] : null
				),
				null, false, false
			);*/
			?>
		</div>
	</div>
	<?php endif; ?>

	<?php if (isset($element)): ?>
	<?php
	if (!empty($element[$element['type']]) || in_array($element['type'], array('Image', 'Archive', 'Contact', 'Login'))):
		$class = sprintf(
			'webpage-element webpage-%s webpage-unit%s',
			str_replace('_', '-', Inflector::underscore($element['type'])),
			!empty($element['align']) ? ' ' . $element['align'] : ''
		);
	?>
	<div class='<?php echo $class; ?>'>
		<!-- Actions -->
		<div class='webpage-actions'>
			<div class='btn-group'>
				<?php
				if (isset($element)) {
					if (!empty($element[$element['type']]) && !in_array($element['type'], array('Contact', 'Login'))) {
						$controller = Inflector::tableize(sprintf(
							'%s%s',
							in_array($element['type'], array('Map')) ? 'WebPage' : '',
							$element['type']
						));

						echo $this->Html->link(
							'<i class="fas fa-edit"></i>',
							array('controller' => $controller, 'action' => 'edit', $element[$element['type']]['id']),
							array(
								'class' => 'btn btn-sm btn-warning',
								'escape' => false
							)
						);
					} elseif (in_array($element['type'], array('Image', 'Archive'))) {
						echo $this->Html->link(
							'<i class="fas fa-edit"></i>',
							array('controller' => Inflector::tableize($element['type']), 'action' => 'add', $element['id']),
							array(
								'class' => 'btn btn-sm btn-warning',
								'escape' => false
							)
						);
					}

					echo $this->Html->link(
						"<i class='far fa-trash-alt'></i>",
						'#',
						array(
							'escape' => false,
							'class' => 'btn btn-danger btn-sm',
							'data-delete',
							'data-dialog' => __('delete-dialog'),
							'data-redirect' => $this->Html->url(array('action' => 'index')),
							'data-model' => 'WebPageElement',
							'data-id' => $element['id'],
							'data-name' => $element['name'],
							'data-url' => '/admin/web_page_elements'
						)
					);
				}
				?>
			</div>
		</div>

		<?php
		echo $this->element('admin/web_pages/' . strtolower($element['type']), array(
			strtolower($element['type']) => empty($element[$element['type']]) ? null : $element[$element['type']],
			'sLayout' => $section['layout'],
			'column' => $column,
			'element' => $element
		));
		?>
	</div>
	<?php else : ?>
		<div class='webpage-intent'>
			<?php
			echo $this->Html->link(
				"<i class='far fa-trash-alt'></i>",
				'#',
				array(
					'escape' => false,
					'class' => 'btn btn-danger btn-sm',
					'data-delete',
					'data-dialog' => __('delete-dialog'),
					'data-redirect' => $this->Html->url(array('action' => 'index')),
					'data-model' => 'WebPageElement',
					'data-id' => $element['id'],
					'data-name' => $element['name'],
					'data-url' => '/admin/web_page_elements'
				)
			);
			?>
		</div>
	<?php endif; ?>
	<?php endif; ?>
</div>

<?php if (isset($element) && ( in_array($element['type'], array('Contact', 'Login', 'Map')) || !isset($element['wrap']) || $element['wrap'] != 1)): ?>
<div class='webpage-break'></div>
<?php endif; ?>
