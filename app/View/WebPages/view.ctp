<?php
$this->Package->assign('vendor', 'js', array(
	'vendor.bootstrap-4.carousel'
));
$this->Package->assign('view', 'css', array(
	'site.core.webpage'
));

$this->assign('title', __('page-title', $page[$localeModel]['name'], $config['App']['configurations']['website-title']));
$this->assign('meta', $page['WebPage'][$locale . '_meta_tags']);


$this->assign('navItemKey', $navItemKey);
?>
<div class='webpage'>
	<?php echo $this->element('site/web_pages/layout', array('page' => $page[$localeModel])); ?>
</div>
