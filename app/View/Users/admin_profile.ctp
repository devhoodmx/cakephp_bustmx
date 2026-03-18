<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);

$pageTitle = __('Cuenta');

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));

// Create Form
echo $this->BootForm->create(
	$model,
	array(
		'data-model' => $model,
		'data-id' => $currentUser['id']
	)
);
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $pageTitle; ?></h1>

	<div class='btn-toolbar pull-right'>
		<?php
		echo $this->BootForm->submit(__('save'), array(
			'class' => 'btn-sm btn-success',
			'div' => false
		));
		?>
	</div>
</div>
<!-- End header -->

<div class='doc-body-row layout-aside-4'>
	<div class='doc-body-main'>
		<?php
		echo $this->BootForm->input($model . '.email', array(
			'type' => 'email'
		));

		echo $this->BootForm->input($model . '._current_password', array(
			'type' => 'password'
		));

		echo $this->BootForm->input($model . '._password', array(
			'type' => 'password'
		));

		echo $this->BootForm->input($model . '._password_confirmation', array(
			'type' => 'password'
		));

		echo $this->BootForm->input($model . '.bio', array(
			'type' => 'textarea'
		));
		?>
	</div>

	<aside class='doc-body-aside'>
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h2 class='panel-title'><?php echo __d('user', 'profile-picture'); ?></h2>
			</div>

			<div class='panel-body'>
				<?php
				$mediaConfig['mediaLabel'] = false;
				echo $this->element('admin/widgets/media/manager', $mediaConfig);
				?>
			</div>
		</div>
	</aside>
</div>

<?php
echo $this->BootForm->end();
?>
