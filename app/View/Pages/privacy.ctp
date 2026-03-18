<?php
$this->Package->assign('view', 'js', [
	// 'app.pages.privacy'
]);
$this->Package->assign('view', 'css', [
	'view.pages.privacy'
]);

// Page properties
$this->assign('title', __('page-title', __('Política de privacidad'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<section class='page-section'>
	<div class='container'>
		<h1><?php echo __('Aviso de <span>privacidad</span>'); ?></h1>

		<?php echo $config['App']['configurations']['legal-privacy']; ?>
	</div>
</section>
