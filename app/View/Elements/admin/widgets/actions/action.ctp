<?php

if (!empty($actionOptions)) {
	extract($actionOptions);
}

$size = empty($size) ? 'sm' : $size;
$actionClass = empty($actionClass) ? 'btn-default' : $actionClass;
$title = empty($actionTitle) ? NULL : $actionTitle;
$url = empty($actionUrl) ? '#' : $actionUrl;

$actionOptions['escape'] = FALSE;
$actionOptions['title'] = $title;

if (!empty($menuItem)) {
	$actionOptions['role'] = 'menuitem';
} else {
	$actionOptions['class'] = 'btn btn-' . $size . ' ' . $actionClass;
	$actionOptions['class'] = !empty($showTitle) ? $actionOptions['class'] . ' show-text' : $actionOptions['class'];
}

if (!empty($actionOptions)) {
	unset($actionOptions['linkOnly']);
	unset($actionOptions['showTitle']);
	unset($actionOptions['menuItem']);
	unset($actionOptions['size']);
	unset($actionOptions['actionClass']);
	unset($actionOptions['actionTitle']);
	unset($actionOptions['actionUrl']);
}

$link = $this->Html->link(
	"<i class='fas fa-" . $icon ."'></i> <span class='btn-text'>" . $title . "</span>",
	$url,
	$actionOptions
);

echo empty($linkOnly) ? $this->Html->tag('div', $link, array('class' => 'btn-group')) : $link;
?>
