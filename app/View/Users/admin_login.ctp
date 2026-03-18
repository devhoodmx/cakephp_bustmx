<?php
$this->Package->assign('view', 'js', array(
	'app.users.admin-login'
));
$this->Package->assign('view', 'css', array(
	'admin.core.login'
));

$this->assign('title', __d('admin', 'page-title', __('Login'), $config['simian']['title'], $config['simian']['version']));
?>

<div id='login'>
	<!-- Logo -->
	<?php
	echo $this->Html->link(
		$this->Html->image(
			$config['simian']['logo'],
			['alt' => $config['simian']['title']]
		),
		array('controller' => 'users', 'action' => 'login'),
		array('id' => 'logo', 'escape' => false)
	);
	?>

	<!-- Login form -->
	<?php
	echo $this->Flash->render('auth');

	echo $this->BootForm->create('User', array(
		'async' => false
	));

		// Username
		echo $this->BootForm->input('username', array(
			'label' => array('text' => __('Usuario'), 'class' => 'sr-only'),
			'placeholder' => __('Usuario'),
			'type' => 'text',
			'autofocus' => true
		));

		// Password
		echo $this->BootForm->input('password', array(
			'label' => array('text' => __('Contraseña'), 'class' => 'sr-only'),
			'placeholder' => __('Contraseña'),
			'type' => 'password'
		));

		// Submit
		echo $this->BootForm->submit(__('ENTRAR'), array(
			'class' => 'btn-primary btn-sm login-btn'
		));

	echo $this->BootForm->end();
	?>

	<?php if (false): ?>
	<!-- Forgot your password? -->
	<?php
	echo $this->Html->link(
		'<small>' . __('Olvidé mi contraseña') . '</small>',
		'#',
		array(
			'escape' => false
		)
	);
	?>
	<?php endif; ?>
</div>

<!-- Credits -->
<div id='credits'>
	<!-- affenbits -->
	<?php
	echo $this->Html->link(
		$this->Html->image('admin/icons/affenbits.svg', array('alt' => 'affenbits')),
		'https://affenbits.com/',
		array('escape' => false, 'title' => 'Hecho por los monos en affenbits', 'class' => 'contributor affenbits')
	);
	?>
</div>
