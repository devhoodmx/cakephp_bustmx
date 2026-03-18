<?php
$this->Package->assign('view', 'js', array(
	'app.users.admin-login'
));
$this->Package->assign('view', 'css', array(
	'admin.core.login'
));

$this->assign('title', __('Login') . ' | ' . __('Site'));

// Image background
$this->Html->scriptStart(array('inline' => false));
?>
hozen.app.backgroundImage = 'http://lorempixel.com/1280/960/nature';
<?php
$this->Html->scriptEnd();
?>

<div id='login'>
	<!-- Logo -->
	<?php
	echo $this->Html->link(
		$this->Html->image(
			'admin/logo-simian.png',
			array('alt' => 'Simian 3')
		),
		array('controller' => 'pages', 'action' => 'index'),
		array('escape' => false, 'id' => 'logo-simian')
	);
	?>

	<!-- Login form -->
	<?php
	echo $this->BootForm->create('User', array('vertical' => true));
		// User
		echo $this->BootForm->input('user', array(
			'class' => 'form-control',
			'label' => array('text' => __('Usuario'), 'class' => 'sr-only'),
			'placeholder' => __('Usuario'),
			'type' => 'text'
		));

		// Password
		echo $this->BootForm->input('pass', array(
			'class' => 'form-control',
			'label' => array('text' => __('Contraseña'), 'class' => 'sr-only'),
			'placeholder' => __('Contraseña'),
			'type' => 'password'
		));

		// Submit
		echo $this->BootForm->submit(__('ENTRAR'), array(
			'buttonType' => 'primary',
			'class' => 'btn-sm'
		));

	echo $this->BootForm->end();
	?>

	<!-- Lost pass -->
	<?php echo $this->Html->link('<small>' . __('Olvidé mi contraseña') . '</small>', '#', array('escape' => false)); ?>
</div>

<!-- Credits -->
<div id='credits'>
	<!-- Hint -->
	<?php
	echo $this->Html->link(
		__('Hint'),
		'http://hint.mx/',
		array('escape' => false, 'title' => 'Hint', 'class' => 'contributor hint')
	);
	?>

	<!-- affenbits -->
	<?php
	echo $this->Html->link(
		__('affenbits'),
		'http://affenbits.com/',
		array('escape' => false, 'title' => 'Hecho por los monos en affenbits', 'class' => 'contributor affenbits')
	);
	?>
</div>
