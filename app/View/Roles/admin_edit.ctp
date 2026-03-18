<?php
$this->Package->assign('view', 'js', array(
	'component.checkbox-tree'
));
$this->Package->assign('view', 'css', array(
	'admin.component.checkbox-tree'
));

$pageTitle = __d('modules', 'roles');

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'roles');

// Create Form
echo $this->BootForm->create(
	'Role',
	array(
		'data-model' => 'Role',
		'data-id' => $role['Role']['id']
	)
);
?>
<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $pageTitle; ?></h1>
	<?php
		echo $this->element(
			'admin/widgets/form/actions',
			array(
				'delete' => true,
				'model' => 'Role',
				'id' => $role['Role']['id'],
				'name' => $role['Role']['name']
			)
		);
	?>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<?php echo $this->BootForm->input('name'); ?>

	<?php echo $this->BootForm->input('key'); ?>

	<div class='checkbox-tree-component' data-component='checkbox-tree'>
		<fieldset>
			<legend>
				<div class='input checkbox'>
					<input id='permissions-title-checkbox' class='checkbox-toggle-all' type='checkbox' value='' />
					<label for='permissions-title-checkbox'><?php echo __d('roles', 'Permisos'); ?></label>
				</div>
			</legend>

			<div class='checkbox-groups'>
				<?php
				$categoryIndex = 0;
				$model = 'Aco';

				foreach ($modules as $category => $group):
				?>
				<div class='checkbox-group'>
					<div class='checkbox-category h4'>
						<div class='input checkbox'>
							<input id='permission-category-checkbox-<?php echo $categoryIndex; ?>' type='checkbox' value='' />
							<label for='permission-category-checkbox-<?php echo $categoryIndex; ?>'><?php echo $category; ?></label>
							<?php $categoryIndex++; ?>
						</div>
					</div>

					<div class='checkboxes'>
						<?php foreach ($group as $module): ?>
						<div class='checkbox-section'>
							<?php
							echo $this->BootForm->input('Aco.' . $module['Module']['id'], [
								'legend' => false,
								'type' => 'checkbox',
								'label' => $module['Module']['name'],
								'value' => $module['Module']['id']
							]);
							?>

							<?php if (!empty($module['children'])): ?>
							<div class='checkboxes'>
								<?php foreach ($module['children'] as $key => $child): ?>
								<div class='checkbox-section'>
									<?php
									echo $this->BootForm->input('Aco.' . $child['Module']['id'], [
										'legend' => false,
										'type' => 'checkbox',
										'label' => $child['Module']['name'],
										'value' => $child['Module']['id']
									]);
									?>
								</div>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</fieldset>
	</div>
</div>

<?php
echo $this->BootForm->end();
// End main form
?>
