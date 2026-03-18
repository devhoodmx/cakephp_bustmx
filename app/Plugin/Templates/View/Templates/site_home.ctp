<?php
$this->Package->assign('view', 'js', array(
	//'app.pages.template'
));
$this->Package->assign('view', 'css', array(
	// 'view.pages.template'
));

// Page properties
$this->assign('title', __('page-title', __('Home'), __('Site')));
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'home');
?>
<div class='container'>
	<div class='doc-section'>
	</div>
</div>
