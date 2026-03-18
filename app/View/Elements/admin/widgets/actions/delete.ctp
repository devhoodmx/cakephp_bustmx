<?php
$size = empty($size) ? 'sm' : $size;
$title = __('delete');
$class = 'btn btn-' . $size . ' btn-danger' . (!empty($showTitle) ?  ' show-text' : '');
$disabled = !empty($disabled);

if ($disabled) {
	$class .= ' disabled';
}

$options = array(
	'escape' => false,
	'class' => $class,
	'title' => $title,
	'data-delete',
	'data-title' => __('delete-dialog-title'),
	'data-dialog' => __('delete-dialog'),
	'data-dialog-accept' => __('delete-dialog-accept')
);

if (!empty($menuItem)) {
	unset($options['class']);
	$options['role'] = 'menuitem';
}

$link = $this->Html->link(
	"<i class='far fa-trash-alt'></i> <span class='btn-text'>" . $title . "</span>",
	'#',
	$options
);

echo empty($linkOnly) ? $this->Html->tag('div', $link, array('class' => 'btn-group')) : $link;
?>
