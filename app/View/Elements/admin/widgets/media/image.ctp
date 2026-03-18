<?php
$path = empty($path) ? '/files/media/image/' : $path;
$path .= $version . '_';
$name = empty($name) ? 'Imagen' : $name;
$attributes = !empty($attributes) ? array_merge(array('alt' => $name), $attributes) : array('alt' => $name);
$file = $key;
$file .= empty($format) ? '' : '.' . $format;

echo $this->Html->image(
	$path . $file,
	$attributes
);
?>