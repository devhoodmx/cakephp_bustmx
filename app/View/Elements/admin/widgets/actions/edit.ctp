<?php
if (empty($editUrl)) {
	$url = array(
		'controller' => $controller,
		'action' => 'edit',
		$id,
		$name
	);
} else {
	$url = $editUrl;
}

$size = empty($size) ? 'sm' : $size;
$title = __('edit');

$options = array(
	'escape' => FALSE,
	'class' => 'btn btn-' . $size . ' btn-info' . (!empty($showTitle) ?  ' show-text' : ''),
	'title' => $title
);

if (!empty($menuItem)) {
	unset($options['class']);
	$options['role'] = 'menuitem';
}

$link = $this->Html->link(
	"<i class='fas fa-edit'></i> <span class='btn-text'>" . $title . "</span>",
	$url,
	$options
);

echo empty($linkOnly) ? $this->Html->tag('div', $link, array('class' => 'btn-group')) : $link;