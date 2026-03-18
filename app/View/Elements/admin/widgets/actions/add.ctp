<?php
$size = empty($size) ? 'sm' : $size;
$class = empty($class) ? 'btn-group' :  ('btn-group ' . $class);
$addUrl = empty($addUrl) ? array('action' => 'add') : $addUrl;

$link = $this->Html->link(
	'<i class="fa fa-plus"></i> ' . __('add'),
	$addUrl,
	array(
		'escape' => false,
		'title' => __('add'),
		'class' => 'btn btn-' . $size . ' btn-primary'
	)
);

echo empty($linkOnly) ? $this->Html->tag('span', $link, array('class' => $class)) : $link;
?>
