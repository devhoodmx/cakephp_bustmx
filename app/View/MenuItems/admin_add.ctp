<?php
$this->Package->assign('view', 'js', array(
	'app.menu-items.admin-add'
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
		'data-reset' => true
	)
);
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'>
		<?php echo $pageTitle; ?>
	</h1>

	<!-- Option buttons -->
	<?php echo $this->element('admin/widgets/form/actions', array('cancelAction' => empty($configView['cancelAction']) ? null : Utility::redirect($configView['cancelAction'], empty($modelData) ? null : $modelData))); ?>
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
			'type' => array(
				'type' => 'select',
				'options' => $types,
				'empty' => __('(Elige una opción)'),
			),
			'es_name' => array(
				'type' => 'text',
				'div' => 'type-input hidden type-external type-header'
			),
			'es_url' => array(
				'type' => 'text',
				'div' => 'type-input hidden type-external',
				'placeholder' => 'https://google.com'
			),
			'internal_id' => array(
				'type' => 'select',
				'empty' => __('(Selecciona una página)'),
				'div' => 'type-input hidden type-internal'
			),
			'_target' => array(
				'type' => 'checkbox',
				'legend' => false,
				'div' => 'type-input type-internal type-external hidden'
			)
		);

		if (sizeof(Configure::read('App.i18n.locales')) > 1) {
			$locales = Configure::read('App.i18n.locales');
			unset($locales[array_search('es', $locales)]);

			foreach ($locales as $locale) {
				$fields[$locale . '_name'] = [
					'type' => 'text',
					'div' => 'type-input hidden type-external type-header'
				];
				$fields[$locale . '_url'] = [
					'type' => 'text',
					'div' => 'type-input hidden type-external',
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
