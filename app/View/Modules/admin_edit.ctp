<?php
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$modelData = $$modelData;

$pageTitle = __d('modules', 'modules');

$this->Package->assign('view', 'js', array(
	'component.checkbox-tree'
));
$this->Package->assign('view', 'css', array(
	'admin.component.checkbox-tree'
));

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'modules');

// Create Form
echo $this->BootForm->create(
	$model,
	array(
		'data-model' => $model,
		'data-id' => $module['Module']['id']
	)
);
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $pageTitle; ?></h1>

	<!-- Option buttons -->
	<?php
	$cancelAction = array(
		'controller' => 'modules',
		'action' => 'index'
	);
	if (!empty($module['Parent']['id'])) {
		$cancelAction[] = $module['Parent']['id'];
		$cancelAction[] = Utility::slug($module['Parent']['name']);
	}

	echo $this->element(
		'admin/widgets/form/actions',
		array(
			'delete' => !isset($module['Module']['deletable']) || $module['Module']['deletable'],
			'model' => $model,
			'id' => $module['Module']['id'],
			'name' => $module['Module']['id'],
			'cancelAction' => $cancelAction
		)
	);
	?>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Columns -->
<div class='doc-body-row<?php echo empty($configView['size'])? '' : ' layout-aside-' . $configView['size'] ?>'>
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

		if (!$module['Parent']['id']) {
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
	<!-- End main -->
</div>
<!-- End container -->

<?php
echo $this->BootForm->end();
// End main form
?>
