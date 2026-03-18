<?php
$this->Package->assign('view', 'js', [
	//'app.controller.action'
]);
$this->Package->assign('view', 'css', [
	'view.errors.admin-error'
]);

// Page properties
$this->assign('title', __('page-title', __('Error'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
// $this->assign('menuItemKey', null);
?>
<h1>
	<?php echo $name; ?>
</h1>

<?php echo $this->element('errors/exception'); ?>
