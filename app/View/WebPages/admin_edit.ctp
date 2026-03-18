<?php
$this->Package->assign('view', 'css', array(
	'admin.component.webpage',
	'view.web-pages.admin-add'
));

$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$modelData = $$modelData;

$pageTitle = __('Editar %s', __d('modules', $modelKey));

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));

// Create Form
echo $this->BootForm->create(
	$model,
	array(
		'data-model' => $model,
		'data-id' => $modelData[$model]['id']
	)
);

if (!empty($modelData[$model]['name'])) {
	$name = $modelData[$model]['name'];
} else if (!empty($modelData[$model]['title'])) {
	$name = $modelData[$model]['title'];
} else if (!empty($modelData[$model]['display_name'])) {
	$name = $modelData[$model]['display_name'];
} else {
	$name = '';
}
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'>
		<?php echo $pageTitle; ?>
		<span class='badge webpage-badge webpage-badge-<?php echo $currentLocale; ?>'><?php echo $currentLocale; ?></span>
	</h1>

	<!-- Option buttons -->
	<?php
	echo $this->element(
		'admin/widgets/form/actions',
		array(
			'delete' => !isset($modelData[$model]['deletable']) || $modelData[$model]['deletable'],
			'model' => $model,
			'id' => $modelData[$model]['id'],
			'name' => $name,
			'cancelAction' => array(
				'action' => 'view',
				$modelData[$model]['id'],
				Utility::slug($modelData[$model]['name']),
				'?' => array('lang' => $currentLocale)
			)
		)
	);
	?>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Columns -->
<div class='doc-body-row'>
	<!-- Main -->
	<div class='doc-body-main'>
		<!-- Form -->
		<?php
		$fields = array(
			$currentLocale . '_name' => array(
				'type' => 'text',
				'label' => __d('web_page', 'name')
			),
			$currentLocale . '_key' => array(
				'type' => 'text',
				'label' => __d('web_page', 'key'),
				'prepend' => '/',
				'placeholder' => __d('web_page', 'placeholder-key-' . $currentLocale)
			),
			$currentLocale . '_meta_tags' => array(
				'type' => 'textarea',
				'label' => __d('web_page', 'meta-tags')
			),
			'active' => array(
				'type' => 'checkbox',
				'legend' => false
			)
		);

		echo $this->element('admin/widgets/form/inputs', array('fields' => $fields, 'modelKey' => $model));
		?>
	</div>
	<!-- End main -->
</div>
<!-- End container -->

<?php
echo $this->BootForm->end();
// End main form
?>
