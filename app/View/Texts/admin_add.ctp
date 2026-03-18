<?php
$title = 'Nuevo texto';
$this->assign('title', __d('admin', 'page-title', $title, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'web_pages');


// Start main form
echo $this->BootForm->create('Text', array(
	'async' => false
));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $title; ?></h1>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<!-- Form -->
	<?php
	echo $this->BootForm->input('text', array(
		'type' => 'editor',
		'label' => 'Texto'
	));

	echo $this->BootForm->input('is_well', array(
		'label' => 'Resaltar texto',
		'legend' => false,
		'type' => 'checkbox'
	));
	?>
</div>

<?php

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
// End main form
?>
