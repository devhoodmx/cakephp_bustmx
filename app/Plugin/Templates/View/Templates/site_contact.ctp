<?php
$this->Package->assign('view', 'js', array(
	//'app.pages.contact'
));
$this->Package->assign('view', 'css', array(
	// 'view.pages.contact'
));

// Page properties
$this->assign('title', __('page-title', __('Contact'), __('Site')));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<div class='container'>
	<div class='doc-section'>
		<?php
		echo $this->BootForm->create('ContactEmail', array(
			'id' => 'contact-form',
			'url' => array('controller' => 'templates', 'action' => 'contact'),
			'novalidate' => true,
			'async' => false
		));
		?>
			<?php
			echo $this->BootForm->input('sender', array(
				'label' => __('Name'),
				'placeholder' => __('Ej. Mono López')
			));

			echo $this->BootForm->input('email', array(
				'label' => __('Email'),
				'placeholder' => __('Ej. mail@domain.com')
			));

			echo $this->BootForm->input('subject', array(
				'label' => __('Subject'),
				'placeholder' => __('Ej. Subject')
			));

			echo $this->BootForm->input('message', array(
				'type' => 'textarea',
				'label' => __('Message')
			));

			// echo $this->element('components/recaptcha');

			echo $this->BootForm->button(__('Send'), array(
				'type' => 'submit',
				'class' => 'btn btn-default'
			));
			?>
		<?php echo $this->BootForm->end(); ?>
	</div>
</div>
