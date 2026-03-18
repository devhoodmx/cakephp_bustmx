<?php
// Requires $value and $field
$size = empty($size) ? 'sm' : $size;
$modelKey = empty($toggleModel) ? NULL : Inflector::underscore($toggleModel);
$fieldKey =  Utility::slug($field);
$titleKey = $fieldKey. '-dialog-title';
$title = '';
$toggleClass = empty($toggleClass) ? 'btn-default' : $toggleClass;
$toggleClass = !empty($showTitle) ?  $toggleClass . ' show-text' : $toggleClass;

if (!empty($value)) {
	$title = Utility::translate('not-' . $titleKey, $modelKey);
}

if (empty($value) || $title == 'not-' . $titleKey) {
	$title = Utility::translate($titleKey, $modelKey);
}

$options = array(
	'escape' => FALSE,
	'title' => $title,
	'class' => 'btn btn-' . $size . ' ' . $toggleClass,
	'data-toggle-field' => $field,
	'data-toggle-value' => empty($value) ? 1 : 0,
	'data-title' =>  $title,
	'data-dialog' => Utility::translate((empty($value) ? '' : 'not-') . $fieldKey . '-dialog', $modelKey)
);

if (!empty($toggleId) && !empty($toggleModel)) {
	$options['data-model'] = $toggleModel;
	$options['data-id'] = $toggleId;
	$options['data-name'] = empty($toggleName) ? '' : $toggleName;
	$options['data-url'] = empty($toggleUrl) ? '/admin/' . Inflector::tableize($toggleModel) : $toggleUrl;
}

if (!empty($menuItem)) {
	unset($options['class']);
	$options['role'] = 'menuitem';
}

if (!empty($directToggle)) {
	$options['data-direct'] = true;
}

$link = $this->Html->link(
	"<i class='fa icon" . (empty($value) ? '-not' : '') . "-" . $fieldKey ."'></i> <span class='btn-text'>" . $title . "</span>",
	'#',
	$options
);

echo empty($linkOnly) ? $this->Html->tag('div', $link, array('class' => 'btn-group')) : $link;
?>
