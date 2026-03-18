<?php
$this->assign('title', __('Add Article') . ' | ' . __('Site'));
$this->set('menuItemKey', 'comments');
$this->set('submenuItemKey', 'labels');

// Start main form
echo $this->BootForm->create('article');
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo __('Noticia nueva'); ?></h1>
	<!-- Option buttons -->
	<div class='btn-toolbar pull-right'>
		<?php
		// Cancel
		echo $this->Html->link(__('Cancelar'),
			'#',
			array('class' => 'btn btn-link btn-sm text-danger')
		);
		// Save and publish
		echo $this->BootForm->submit(__('Guardar y publicar'), array(
			'buttonType' => 'success',
			'class' => 'btn-sm',
			'div' => false
		));
		// Delete
		echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-danger btn-sm'));
		?>
	</div>
</div>
<!-- End header -->

<!-- Columns -->
<div class='doc-body-row layout-aside-3'>
	<!-- Main -->
	<div class='doc-body-main'>
		<!-- Tabs -->
		<ul class='nav nav-tabs'>
			<li class='active'><?php echo $this->Html->link(__('Español'), '#spanish', array('escape' => false, 'data-toggle' => 'tab')); ?></li>
			<li><?php echo $this->Html->link(__('English'), '#english', array('escape' => false, 'data-toggle' => 'tab')); ?></li>
			<li><?php echo $this->Html->link(__('Português'), '#portuguese', array('escape' => false, 'data-toggle' => 'tab')); ?></li>
		</ul>
		<!-- End tabs -->

		<!-- Tab content -->
		<div class='tab-content'>
			<!-- Spanish -->
			<div class='tab-pane active' id='spanish'>
				<!-- URL -->
				<div class='callout'>
					<span class="text-muted">URL: http://ejemplodesitio.com/noticias/</span>titulo-de-la-noticia
				</div>
				<!-- Form -->
				<?php
				// Title
				echo $this->BootForm->input('title', array(
					'label' => __('Título'),
					'type' => 'text'
				));
				// Bullet
				echo $this->BootForm->input('bullet', array(
					'label' => __('Balazo'),
					'type' => 'text'
				));
				// Summary
				echo $this->BootForm->input('summary', array(
					'label' => __('Sumario'),
					'type' => 'text'
				));
				// Content
				echo $this->BootForm->input('content', array(
					'label' => __('Contenido'),
					'type' => 'textarea'
				));

				echo $this->BootForm->input('price', array(
					'label' => 'Precio',
					'prepend' => '$'
				));

				echo $this->BootForm->input('pretty' ,array(
					'legend' => 'Titulo',
					'label' => 'Checkbox Label',
					'type' => 'checkbox'
				));

				echo $this->BootForm->input('group' ,array(
					'label' => __('Grupo'),
					'multiple' => 'checkbox',
					'options' => array(
						0 => __('Grupo 1'),
						1 => __('Grupo 2'),
						2 => __('Grupo 3')
					)
				));

				echo $this->BootForm->input('delivery_service', array(
					'legend' => array('text' => __('Servicio a domicilio')),
					'type' => 'radio',
					'options' => array('No', 'Sí'),
					'default' => 0
				));

				echo $this->BootForm->input('date', array(
					'type' => 'date',
					'size' => 5,
					'label' => 'Ñañañañañaña'
				));

				echo $this->BootForm->input('group', array(
					'label' => __('Grupo'),
					'type' => 'select',
					'size' => 9,
					'options' => array(
						0 => __('Grupo 1'),
						1 => __('Grupo 2'),
						2 => __('Grupo 3')
					)
				));
				?>

				<button class='btn btn-sm btn-success'><i class='fas fa-image'></i> Hola</button>
			</div>
			<!-- English -->
			<div class='tab-pane' id='english'>
				English
			</div>
			<!-- Portuguese -->
			<div class='tab-pane' id='portuguese'>
				Portuguese
			</div>
		</div>
		<!-- End tab content -->

		<!-- Gallery -->
		<div class='panel panel-default no-overflow'>
			<div class='panel-heading boxes'>
				<h2 class='panel-title pull-left'><?php echo __('Galería'); ?></h2>
				<!-- Delete gallery -->
				<?php echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'pull-right text-danger')); ?>
			</div>
			<div class='panel-body'>

			</div>
		</div>
		<!-- End gallery -->

		<!-- Modal -->
		<div>
			<?php
			echo $this->Html->link(__('Open Add File Modal'), '#', array('escape' => false, 'class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#testModal'));
			echo $this->element('admin/modal_files', array(
				'id' => 'testModal', // If of the modal
				'name' => 'testModal' // Name for the "upload-file"

			));
			?>
		</div>
		<!-- End Modal -->
	</div>
	<!-- End main -->

	<!-- Aside -->
	<aside class='doc-body-aside'>
		<!-- Main image -->
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h2 class='panel-title'><?php echo __('Imagen destacada'); ?></h2>
			</div>
			<div class='panel-body'>
				<!-- Image -->
				<?php echo $this->Html->image('http://placehold.it/244x183', array('alt' => __('Imagen'), 'width' => 244, 'height' => 183, 'class' => 'img-responsive img-rounded')); ?>
				<!-- Title -->
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				<!-- Option buttons -->
				<div class="btn-toolbar">
					<!-- Options button -->

					<div class='fancy-input-file'>
						<?php
						echo $this->BootForm->input(
							__('Opciones'),
							array(
								'div' => false,
								'label' => false,
								'type' => 'file',
								'class' => 'btn btn-default btn-sm'
							)
						);
						?>
						<span class='btn btn-default btn-sm fancy-btn'><?php echo __('Opciones'); ?></span>
					</div>
					<!-- Delete button -->
					<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-danger btn-sm')); ?>
				</div>
			</div>
		</div>
		<!-- End main image -->

		<!-- Features -->
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h2 class='panel-title'><?php echo __('Características'); ?></h2>
			</div>
			<div class='panel-body'>
				<?php
				// Type
				echo $this->BootForm->input('type', array(
					'class' => 'form-control',
					'label' => __('Tipo'),
					'type' => 'select',
					'options' => array(
						0 => 'Tipo',
						1 => 'Tipo 2',
						2 => 'Tipo 3'
					)
				));
				// Category
				echo $this->BootForm->input('type', array(
					'class' => 'form-control',
					'label' => __('Categoría'),
					'multiple' => true,
					'type' => 'select',
					'options' => array(
						0 => 'Categoría',
						1 => 'Categoría 2',
						2 => 'Categoría 3'
					)
				));
				?>
				<!-- Published date -->
				<div class='form-group pull-left'>
					<?php echo $this->BootForm->label(__('Fecha de publicación')); ?>
					<p class='text-muted form-control-static'>01/02/03 - 10:30 pm.</p>
				</div>
				<div class='form-group pull-right'>
					<?php echo $this->Html->link(__('Editar'), '#', array('escape' => false)); ?>
				</div>
			</div>
		</div>
		<!-- End features -->
	</aside>
	<!-- End aside -->
</div>
<!-- End container -->

<?php
echo $this->BootForm->end();
// End main form
?>
