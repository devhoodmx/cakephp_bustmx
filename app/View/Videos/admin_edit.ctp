<?php
$title = 'Video';
$this->assign('title', __d('admin', 'page-title', $title, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'web_pages');

// Start main form
echo $this->BootForm->create('Video', array(
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
	echo $this->BootForm->input('id');
	echo $this->BootForm->input('url', array(
		'label' => 'Vínculo',
		'after' => sprintf("<span class='help-block'>%s</span>", __('YouTube, Facebook &amp; Vimeo'))
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
