<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);

$pageTitle = __('add-module', __d('modules', $modelKey) . (empty($parent) ? '' : ' en ' . $parent['Category']['name']));

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'categories');

// Create Form
echo $this->BootForm->create('Category');
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $pageTitle; ?></h1>
	<!-- Option buttons -->
	<?php
	$cancelAction = array(
		'controller' => 'categories',
		'action' => 'index'
	);
	if (!empty($parent)) {
		$cancelAction[] = $parent['Category']['id'];
		$cancelAction[] = Utility::slug($parent['Category']['name']);
	}

	echo $this->element(
		'admin/widgets/form/actions',
		array(
			'cancelAction' => $cancelAction
		)
	);
	?>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<!-- Form -->
	<?php
	echo $this->BootForm->input('name');

	echo $this->BootForm->input('code');

	if (Utility::is('prosimian')) {
		echo $this->BootForm->input('key');

		echo $this->BootForm->input('class');
	}

	echo $this->BootForm->input('color', array(
		'placeholder' => '#35BDB2'
	));
	?>
</div>

<?php
echo $this->BootForm->end();
// End main form
?>
