<?php
$this->assign('title', __('Add/Edit User') . ' | ' . __('Site'));

// Start main form
echo $this->BootForm->create('user', array('type' => 'file', 'horizontal' => true));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo __('Nuevo usuario / Editar usuario'); ?></h1>
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
		<?php
		// Avatar
		$beforeTxt = "<div class='col-lg-9'>";
		$beforeTxt .= $this->Html->image('admin/default-avatar.png', array('alt' => __('Usuario'), 'class' => 'profile-avatar', 'width' => 140, 'height' => 140));
		$afterTxt = "<span class='help-block'>" . __('Archivos soportados: GIF, JPG, JPEG y PNG') . '</span></div>';
		echo $this->BootForm->input('avatar', array(
			'before' => $beforeTxt,
			'after' => $afterTxt,
			'label' => array('text' => __('Imagen de perfil'), 'class' => 'col-lg-3'),
			'type' => 'file'
		));
		// Username
		echo $this->BootForm->input('username', array(
			'before' => "<div class='col-lg-9'>",
			'after' => '</div>',
			'label' => array('text' => __('Nombre de usuario'), 'class' => 'col-lg-3'),
			'placeholder' => __('Ej. loremIpsum')
		));
		// Name
		echo $this->BootForm->input('name', array(
			'before' => "<div class='col-lg-9'>",
			'after' => '</div>',
			'label' => array('text' => __('Nombre'), 'class' => 'col-lg-3'),
			'placeholder' => __('Ej. John')
		));
		// Last name
		echo $this->BootForm->input('lastName', array(
			'before' => "<div class='col-lg-9'>",
			'after' => '</div>',
			'label' => array('text' => __('Apellido'), 'class' => 'col-lg-3'),
			'placeholder' => __('Ej. Doe')
		));
		// Gender
		echo $this->BootForm->input('gender', array(
			'before' => "<div class='col-lg-9'>",
			'after' => '</div>',
			'legend' => array('text' => __('Género'), 'class' => 'col-lg-3'),
			'type' => 'radio',
			'options' => array(
				0 => __('Hombre'),
				1 => __('Mujer')
			)
		));
		// Email
		echo $this->BootForm->input('email', array(
			'before' => "<div class='col-lg-9'>",
			'after' => '</div>',
			'label' => array('text' => __('Email'), 'class' => 'col-lg-3'),
			'placeholder' => __('Ej. john.doe@mail.com'),
			'type' => 'mail'
		));
		// Password
		$afterTxt = "<span class='help-block'>" . __('Debe ser al menos 8 caracteres') . '</span></div>';
		echo $this->BootForm->input('password', array(
			'before' => "<div class='col-lg-9'>",
			'after' => $afterTxt,
			'label' => array('text' => __('Contraseña'), 'class' => 'col-lg-3'),
			'type' => 'password'
		));
		// Confirm password
		echo $this->BootForm->input('confirmation', array(
			'before' => "<div class='col-lg-9'>",
			'after' => '</div>',
			'label' => array('text' => __('Confirmar contraseña'), 'class' => 'col-lg-3'),
			'type' => 'password'
		));
		// Group
		echo $this->BootForm->input('group', array(
			'before' => "<div class='col-lg-3'>",
			'after' => '</div>',
			'label' => array('text' => __('Grupo'), 'class' => 'col-lg-3'),
			'type' => 'select',
			'options' => array(
				0 => __('Grupo 1'),
				1 => __('Grupo 2'),
				2 => __('Grupo 3')
			)
		));
		?>
	</div>
	<!-- End main -->

	<!-- Aside -->
	<aside class='doc-body-aside'>
		<!-- Well -->
		<div class='well'>
			<?php for ($index = 0; $index < 3; $index++): ?>
			<p>
				<strong>Well.</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis dolorem est impedit quo vitae. Aliquam architecto consequuntur cum dignissimos dolore enim, harum id labore odio officiis quaerat sequi similique totam.
			</p>
			<?php endfor; ?>
		</div>
		<!-- End well -->
	</aside>
	<!-- End aside -->
</div>
<!-- End columns -->

<?php
echo $this->BootForm->end();
// End main form
?>
