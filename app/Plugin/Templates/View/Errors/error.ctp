<?php
$this->Package->assign('view', 'js', array(
	//'app.controller.action'
));
$this->Package->assign('view', 'css', array(
	'view.errors.error'
));

// Page properties
$this->assign('title', __('page-title', __('Error'), __('Site')));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<h1>
	<?php echo $name; ?>
</h1>

<?php echo $this->element('errors/exception'); ?>
