<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$modelData = $$modelData;

$pageTitle = __('Editar %s', __('Mapa'));

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
				'cancelAction' => empty($configView['cancelAction']) ? $referer : Utility::redirect($configView['cancelAction'], empty($modelData) ? NULL : $modelData)
			)
		);
	?>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Columns -->
<div class='doc-body-row<?php echo empty($configView['size'])? '' : ' layout-aside-' . $configView['size'] ?>'>
	<!-- Main -->
	<div id='form-body' class='doc-body-main'>

		<!-- Form -->
		<?php
		$fields = array(
			'latitude' => array(
				'type' => 'number',
				'placeholder' => '20.9966119'
			),
			'longitude' => array(
				'type' => 'number',
				'placeholder' => '-89.6172316'
			),
			'zoom' => array(
				'type' => 'number',
				'placeholder' => '15'
			),
			'height' => array(
				'type' => 'text',
				'placeholder' => '200'
			)
		);

		echo $this->element('admin/widgets/form/inputs', array('fields' => $fields, 'modelKey' => $model));
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
