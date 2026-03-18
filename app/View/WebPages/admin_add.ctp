<?php
$this->Package->assign('view', 'css', array(
	'admin.component.webpage',
	'view.web-pages.admin-add'
));

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
	<h1 class='pull-left'>
		<?php echo $pageTitle; ?>
		<span class='badge webpage-badge webpage-badge-<?php echo $currentLocale; ?>'><?php echo $currentLocale; ?></span>
	</h1>

	<!-- Option buttons -->
	<?php echo $this->element('admin/widgets/form/actions', array('cancelAction' => empty($configView['cancelAction']) ? NULL : Utility::redirect($configView['cancelAction'], empty($modelData) ? NULL : $modelData))); ?>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Columns -->
<div class='doc-body-row<?php echo empty($configView['size'])? '' : ' layout-aside-' . $configView['size'] ?>'>
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
			<?php echo $this->element('admin/widgets/form/aside', array('boxes' => $configView['fields']['aside'], 'modelKey' => $modelKey)); ?>
		</aside>
		<!-- End aside -->
	<?php endif ?>
</div>
<!-- End container -->

<?php
echo $this->BootForm->end();
// End main form
?>
