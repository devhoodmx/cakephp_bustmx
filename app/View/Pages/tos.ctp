<?php
$this->Package->assign('view', 'js', [
	// 'app.pages.tos'
]);
$this->Package->assign('view', 'css', [
	// 'view.pages.tos'
]);

// Page properties
$this->assign('title', __('page-title', __('Términos y condiciones'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<section class='page-section'>
	<div class='container'>
		<h1><?php echo __('Términos y condiciones'); ?></h1>

		<?php echo $config['App']['configurations']['legal-tos']; ?>
	</div>
</section>
