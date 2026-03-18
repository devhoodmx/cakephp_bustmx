<?php
$this->Package->assign('view', 'js', array(
	'app.templates.index'
));
$this->Package->assign('view', 'css', array(
	'view.templates.index'
));

// Page properties
$this->assign('title', __('page-title', __('Templates'), __('Site')));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<div class='doc-section'>
	<h1>
		<?php
		echo $this->Html->link(
			__('Templates'),
			array('controller' => 'templates', 'action' => 'index')
		);
		?>
	</h1>

	<?php foreach ($templates as $key => $set): ?>
	<h2 id='<?php echo $key; ?>'><?php echo $key; ?></h2>

	<?php
	echo $this->element('templates', array(
		'templates' => $set,
		'level' => 3,
		'prefix' => $key
	));
	?>
	<?php endforeach; ?>
</div>
