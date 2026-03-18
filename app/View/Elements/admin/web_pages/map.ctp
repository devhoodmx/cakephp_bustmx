<div class='webpage-content'>
	<?php
	echo $this->element('components/map', array(
		'latitude' => $map['latitude'],
		'longitude' => $map['longitude'],
		'zoom' => empty($map['zoom']) ? 15 : $map['zoom'] ,
		'height' => empty($map['height']) ? 200 : $map['height']
	));
	?>
</div>
