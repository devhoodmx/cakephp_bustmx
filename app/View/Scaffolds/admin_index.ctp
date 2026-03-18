<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$modelData = $$modelData;

$pageTitle = __d('modules', $controllerKey);

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1>
		<?php echo $pageTitle; ?>
		<!-- Option buttons -->
		<?php if (!isset($configView['add']) || !empty($configView['add'])) : ?>
			<?php echo $this->element('admin/widgets/actions/add'); ?>
		<?php endif ?>
	</h1>

</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<?php if (!empty($configView['list'])) : ?>
		<?php echo $this->element('admin/widgets/lists/list', array('configList' => $configView['list'], 'listData' => $modelData, 'model' => $model, 'listKey' => $model)); ?>
	<?php endif ?>
</div>
<!-- End container -->

<?php /*

<!-- Columns -->
<div class='doc-body-row<?php echo empty($configView['size'])? '' : ' layout-aside-' . $configView['size'] ?>'>
	<!-- Main -->
	<div class='doc-body-main'>

		<!-- Form -->
		<?php
		if (!empty($configView['fields']['main'])) {
			echo $this->element('admin/widgets/form/inputs', array('fields' => $configView['fields']['main']));
		}
		?>
	</div>
	<!-- End main -->

	<?php if (!empty($configView['fields']['aside'])) : ?>
		<!-- Aside -->
		<aside class='doc-body-aside'>
			<?php echo $this->element('admin/widgets/form/aside', array('boxes' => $configView['fields']['aside'], 'modelKey' => $modelKey)); ?>
		</aside>
		<!-- End aside -->
	<?php endif ?>
</div>
<!-- End container -->
*/ ?>