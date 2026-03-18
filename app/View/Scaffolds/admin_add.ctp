<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);

$pageTitle = __('add-module', __d('modules', $modelKey));

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));

// Create Form
echo $this->BootForm->create(
	$model,
	array(
		'data-model' => $model,
		'data-reset' => TRUE
	)
);
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $pageTitle; ?></h1>

	<!-- Actions -->
	<?php
	$cancelAction = null;

	if ($this->request->query('from')) {
		$cancelAction = $this->request->query('from');
	} elseif (!empty($configView['cancelAction'])) {
		$cancelAction = Utility::redirect($configView['cancelAction'], empty($modelData) ? null : $modelData);
	}

	echo $this->element(
		'admin/widgets/form/actions',
		[
			'cancelAction' => $cancelAction
		]
	);
	?>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Columns -->
<div class='doc-body-row<?php echo empty($configView['size']) && empty($configView['fields']['aside']) ? '' : (' layout-aside-' . (empty($configView['size']) ? 4 : $configView['size'])) ?>'>
	<!-- Main -->
	<div class='doc-body-main'>

		<!-- Form -->
		<?php
		if (!empty($configView['fields']['main'])) {
			echo $this->element('admin/widgets/form/inputs', array('fields' => $configView['fields']['main'], 'modelKey' => $model));
		}
		?>
	</div>
	<!-- End main -->

	<?php if (!empty($configView['fields']['aside'])) : ?>
		<!-- Aside -->
		<aside class='doc-body-aside'>
			<?php echo $this->element('admin/widgets/form/inputs', array('fields' => $configView['fields']['aside'], 'modelKey' => $model, 'aside' => true)); ?>
		</aside>
		<!-- End aside -->
	<?php endif ?>
</div>
<!-- End container -->

<?php
echo $this->BootForm->end();
// End main form
?>
