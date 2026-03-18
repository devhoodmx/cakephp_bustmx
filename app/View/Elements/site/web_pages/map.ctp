<div class='webpage-element webpage-map'>
	<?php
	echo $this->element('components/map', array(
		'latitude' => $element['Map']['latitude'],
		'longitude' => $element['Map']['longitude'],
		'zoom' => empty($element['Map']['zoom']) ? 15 : $element['Map']['zoom'] ,
		'height' => empty($element['Map']['height']) ? 200 : $element['Map']['height']
	));
	?>
</div>
