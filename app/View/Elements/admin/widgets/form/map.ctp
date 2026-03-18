<?php
$serviceKey = Configure::read('App.services.google-maps.api-key');
$url = sprintf(
	'https://maps.googleapis.com/maps/api/js?key=%s&callback=%s',
	$serviceKey,
	'onMapLoaded'
);

echo $this->Html->script($url, array('block' => 'posscript', 'defer' => true, 'async' => true, 'inline' => false));

$this->Package->append('view', 'js', array(
	'widget.map'
));

$this->Package->append('view', 'css', array(
	'admin.widget.map'
));

echo $this->BootForm->input($field . 'lat', ['type' => 'hidden', 'id' => Utility::slug($field . 'lat'), 'default' => 20.954]);
echo $this->BootForm->input($field . 'lng', ['type' => 'hidden', 'id' => Utility::slug($field . 'lng'), 'default' => -89.628]);
echo $this->BootForm->input($field . 'zoom', ['type' => 'hidden', 'id' => Utility::slug($field . 'zoom'), 'default' => 11]);
?>
<div class='map-input' data-widget-map='<?php echo Utility::slug($field . 'map'); ?>' data-widget-map-lat='<?php echo Utility::slug($field . 'lat'); ?>' data-widget-map-lng='<?php echo Utility::slug($field . 'lng'); ?>' data-widget-map-zoom='<?php echo Utility::slug($field . 'zoom'); ?>'></div>