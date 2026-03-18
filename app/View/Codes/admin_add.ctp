<?php
$title = 'Nuevo código';
$this->assign('title', __d('admin', 'page-title', $title, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'web_pages');


// Start main form
echo $this->BootForm->create('Code', array(
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
	<div class='form-group'>
		<?php
		echo $this->element('components/ace', array(
			'language' => 'html',
			'input' => array(
				'key' => 'code'
			)
		));
		?>
	</div>
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
