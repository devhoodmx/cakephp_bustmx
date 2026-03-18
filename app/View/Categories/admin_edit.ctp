<?php
$controllerKey = Utility::slug($this->params['controller']);

$pageTitle = __('Editar %s %s', strtolower(__d('modules', 'category')), $category['Category']['name']);

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
	<div class='btn-toolbar pull-right'>
		<?php
		echo $this->element(
			'admin/widgets/form/actions',
			array(
				'delete' => !isset($category['Category']['deletable']) || $category['Category']['deletable'],
				'model' => 'Category',
				'id' => $category['Category']['id'],
				'name' => $category['Category']['name'],
				'cancelAction' => array(
					'controller' => 'categories',
					'action' => 'index',
					$category['ParentCategory']['id'],
					Utility::slug($category['ParentCategory']['name'])
				)
			)
		);
		?>
	</div>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<!-- Form -->
	<?php
	echo $this->BootForm->input('id');

	echo $this->BootForm->input('name');

	echo $this->BootForm->input('code');

	if (Utility::is('prosimian')) {
		echo $this->BootForm->input('key');

		echo $this->BootForm->input('class');
	}

	echo $this->BootForm->input('color', array(
		'placeholder' => '#35BDB2'
	));

	echo $this->BootForm->input('parent_id', array(
		'type' => 'select',
		'options' => $categories,
		'empty' => __d('category', 'Elige una categoría')
	));
	?>
</div>

<?php
echo $this->BootForm->end();
// End main form
?>
