<!-- Modal -->
<div id='LoginModal' class='modal fade' tabindex='-1' role='dialog' data-backdrop='static' data-keyboard='0'>
	<div class='modal-dialog modal-sm' role='document'>
		<div class='modal-content'>
			<div class='modal-body text-center'>
				<br />

				<?= $this->Html->image($config['simian']['logo'], ['alt' => $config['simian']['title']]); ?>

				<br /><br /><br />

				<div class='text-muted'>Su sesión ha expirado<br />Renueve su acceso</div>

				<br />

				<?php
				echo $this->BootForm->create('User', array(
					'async' => true,
					'id' => 'UserExpiredLoginForm',
					'url' => ['controller' => 'users', 'action' => 'login']
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
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->