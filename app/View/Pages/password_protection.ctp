<?php
$this->Package->assign('view', 'css', array(
	'admin.core.password'
));

$this->assign('title', __d('admin', 'page-title', __('Acceso protegido con contraseña'), $config['simian']['title'], $config['simian']['version']));
?>

<div class='container bg-light d-flex flex-column align-items-center justify-content-center min-vw-100 min-vh-100 p-5'>
	<!-- Logo -->
	<?php
	echo $this->Html->image(
		'affenbits.svg',
		array(
			'class' => 'logo',
			'alt' => 'affenbits'
		)
	);
	?>

	<!-- Login form -->
	<?= $this->BootForm->create('User') ?>

	<div class='input-group position-relative mt-5'>
		<div class='input-group-prepend'><span class='input-group-text text-muted'><i class='fa fa-lock'></i></span></div>

		<?php
		echo $this->BootForm->input('password', [
			'div' => 'mb-0',
			'label' => false,
			'class' => 'rounded-0',
			'placeholder' => __('Contraseña')
		]);
		?>

		<div class='input-group-append'>
			<?php
			echo $this->BootForm->button(
				__('Acceder'),
				['class' => 'btn btn-info', 'escape' => false, 'type' => 'submit']
			);
			?>
		</div>
	</div>

	<?= $this->BootForm->end() ?>
</div>
