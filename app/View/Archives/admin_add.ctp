<?php
$title = 'Archivos';
$this->assign('title', __d('admin', 'page-title', $title, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'web_pages');
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $title; ?></h1>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<?php
	echo $this->BootForm->create('WebPageElement', array(
		'data-model' => 'WebPageElement',
		'data-id' => $webPageElement['WebPageElement']['id'],
		'async' => false,
		'url' => array('controller' => 'images', 'action' =>  'add', $webPageElement['WebPageElement']['id'])
	));

	$mediaConfig['archive']['mediaLabel'] = false;
	$mediaConfig['archive']['from'] = $this->request->here();
	echo $this->element('admin/widgets/media/manager', $mediaConfig['archive']);

	echo $this->BootForm->input('id', array(
		'type' => 'hidden',
		'value' => $webPageElement['WebPageElement']['id']
	));

	// Save
	echo $this->BootForm->submit('Guardar', array(
		'buttonType' => 'success',
		'class' => 'btn-sm',
		'div' => false
	));

	// Cancel
	echo $this->Html->link(__('cancel'),
		$referer,
		array('class' => 'btn btn-link btn-sm text-danger')
	);

	echo $this->BootForm->end();
	?>
</div>
