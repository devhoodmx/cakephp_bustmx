<?php
$pageTitle = __('add-module', __d('modules', 'role'));

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'roles');

echo $this->BootForm->create('Role', array('async' => false));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $pageTitle; ?></h1>
	<!-- Option buttons -->
	<?php echo $this->element('admin/widgets/form/actions'); ?>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<!-- Form -->
	<?php echo $this->BootForm->input('name'); ?>

	<?php echo $this->BootForm->input('key'); ?>
</div>

<?php
echo $this->BootForm->end();
// End main form
?>