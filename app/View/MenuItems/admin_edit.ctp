<?php
$this->Package->assign('view', 'js', array(
	'app.menu-items.admin-add'
));
$this->Package->assign('view', 'css', array(
	'view.menu-items.admin-edit'
));

$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$modelData = $$modelData;

$pageTitle = __('Editar %s', $menuItem['MenuItem']['es_name']);

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

		<small class='text-muted'>
			<?php
			echo $this->element('admin/menu_items/link', array(
				'item' => $menuItem
			));
			?>
		</small>
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
				'cancelAction' => empty($configView['cancelAction']) ? NULL : Utility::redirect($configView['cancelAction'], empty($modelData) ? NULL : $modelData)
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
		$type = $menuItem['MenuItem']['type'];
		$fields = array(
			'type' => array(
				'type' => 'select',
				'options' => $types,
				'empty' => __('(Elige una opción)'),
			),
			'es_name' => array(
				'type' => 'text',
				'div' => 'type-input type-external type-header' . (($type == 'external' || $type == 'header') ? '' : ' hidden')
			),
			'es_url' => array(
				'type' => 'text',
				'div' => 'type-input type-external' . (($type == 'external') ? '' : ' hidden'),
				'placeholder' => 'https://google.com'
			),
			'internal_id' => array(
				'type' => 'select',
				'empty' => __('(Selecciona una página)'),
				'div' => 'type-input type-internal' . (($type == 'internal') ? '' : ' hidden')
			),
			'parent_id' => array(
				'type' => 'select',
				'empty' => __('-')
			),
			'_target' => array(
				'type' => 'checkbox',
				'legend' => false,
				'div' => 'type-input type-internal type-external'. (($type == 'internal' || $type == 'external') ? '' : ' hidden')
			)
		);

		if (sizeof(Configure::read('App.i18n.locales')) > 1) {
			$locales = Configure::read('App.i18n.locales');
			unset($locales[array_search('es', $locales)]);

			foreach ($locales as $locale) {
				$fields[$locale . '_name'] = [
					'type' => 'text',
					'div' => 'type-input type-external type-header' . (($type == 'external' || $type == 'header') ? '' : ' hidden')
				];
				$fields[$locale . '_url'] = [
					'type' => 'text',
					'div' => 'type-input type-external' . (($type == 'external') ? '' : ' hidden'),
					'placeholder' => 'https://google.com'
				];
			}
		}

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
