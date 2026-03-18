<?php
$title = empty($parent) ? __('add-module', 'Módulo') : __('add-submodule', $parent['Module']['name']);

$this->Package->assign('view', 'js', array(
	'component.checkbox-tree'
));
$this->Package->assign('view', 'css', array(
	'admin.component.checkbox-tree'
));

$this->assign('title', __d('admin', 'page-title', $title, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'modules');

// Start main form
echo $this->BootForm->create('Module');
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $title; ?></h1>

	<?php
	$cancelAction = array(
		'controller' => 'modules',
		'action' => 'index'
	);
	if (!empty($parent)) {
		$cancelAction[] = $parent['Module']['id'];
		$cancelAction[] = Utility::slug($parent['Module']['name']);
	}

	echo $this->element(
		'admin/widgets/form/actions',
		array(
			'cancelAction' => $cancelAction
		)
	);
	?>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<!-- Form -->
	<?php
	echo $this->BootForm->input('name', [
		'placeholder' => 'Usuarios'
	]);

	echo $this->BootForm->input('model', [
		'placeholder' => 'User'
	]);

	echo $this->BootForm->input('key', [
		'placeholder' => 'users'
	]);

	echo $this->BootForm->input('url', [
		'placeholder' => '/admin/users'
	]);

	if (!empty($parent) || $this->request->query('category_id')) {
		$categoryId = null;

		if (!empty($parent)) {
			$categoryId = $parent['Module']['category_id'];
		} else {
			$categoryId = $this->request->query('category_id');
		}

		echo $this->BootForm->input('category_id', array('type' => 'hidden', 'value' => $categoryId));
	} else {
		echo $this->BootForm->input('category_id', array(
			'type' => 'select',
			'options' => $categories,
			'empty' => '(Selecciona una categoría)'
		));
	}
	?>

	<?php if (!empty($aros)): ?>
	<div class='checkbox-tree-component' data-component='checkbox-tree'>
		<fieldset>
			<legend>
				<div class='input checkbox'>
					<?php $checkboxId = sprintf('checkbox-%s', 0); ?>
					<input id='<?php echo $checkboxId; ?>' class='checkbox-toggle-all' type='checkbox' value='' />
					<label for='<?php echo $checkboxId; ?>'><?php echo __d('modules', 'roles'); ?></label>
				</div>
			</legend>

			<div class='checkbox-groups'>
				<div class='checkbox-group'>
					<div class='checkboxes'>
						<?php foreach ($aros as $aro): ?>
						<div class='checkbox-section'>
							<?php
							$options = array(
								'legend' => false,
								'type' => 'checkbox',
								'label' => $aro['Role']['name'],
								'value' => $aro['Aro']['id']
							);

							if ($aro['Role']['key'] == 'prosimian') {
								$options['checked'] = true;
								$options['disabled'] = true;
							}

							echo $this->BootForm->input('Aro.' . $aro['Aro']['id'], $options);
							?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<?php endif; ?>
</div>

<?php
echo $this->BootForm->end();
// End main form
?>
