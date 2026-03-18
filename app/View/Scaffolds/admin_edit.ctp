<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$modelData = $$modelData;

$pageTitle = __d('modules', $controllerKey);

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));

if (!empty($modelData[$model]['name'])) {
	$name = $modelData[$model]['name'];
} else if (!empty($modelData[$model]['title'])) {
	$name = $modelData[$model]['title'];
} else if (!empty($modelData[$model]['display_name'])) {
	$name = $modelData[$model]['display_name'];
} else {
	$name = '';
}

// Create Form
echo $this->BootForm->create(
	$model,
	array(
		'data-model' => $model,
		'data-id' => $modelData[$model]['id'],
		'data-name' => $name,
		 'data-url' => '/admin/' . Inflector::tableize($model)
	)
);

?>

<!-- Header -->
<div class='page-header boxes'>
	<div class='d-flex flex-wrap justify-content-between'>
		<!-- Title -->
		<h1 class='d-flex flex-wrap'>
			<div><?php echo $pageTitle; ?></div>
			<div class='ml-5'>
			<?php echo $this->element('admin/widgets/lists/actions', array('actions' => empty($configView['actions']) ? [] : $configView['actions'], 'itemData' => $modelData, 'model' => $model, 'isHeader' => true)); ?>
			</div>
		</h1>

		<div>
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
					'delete' => !isset($modelData[$model]['deletable']) || $modelData[$model]['deletable'],
					'model' => $model,
					'id' => $modelData[$model]['id'],
					'name' => $name,
					'cancelAction' => $cancelAction
				]
			);
			?>
		</div>
	</div>
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
