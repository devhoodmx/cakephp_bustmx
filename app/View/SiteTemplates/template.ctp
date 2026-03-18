<?php
$this->Package->assign('view', 'js', array(
	//'app.pages.template'
));
$this->Package->assign('view', 'css', array(
	// 'view.pages.template'
));

// Page properties
$this->assign('title', __('page-title', __('Template'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
