<?php
$id = empty($id) ? '' : $id;
$class = sprintf('video-component%s', (empty($class) ?  '' : ' ' . $class));
$source = isset($source) ? $source : '';
$aspect = isset($aspect) ? $aspect : '16by9';
$service = '';
$key = '';

// Services
$services = array(
	'youtube' => array(
		'url' => 'https://www.youtube.com/embed/%s'
	),
	'vimeo' => array(
		'url' => 'https://player.vimeo.com/video/%s'
	),
	'facebook' => array(
		'url' => 'https://www.facebook.com/plugins/video.php?href=%s'
	)
);

// Aspect ratio
if (!in_array($aspect, array('21by9', '16by9', '4by3', '1by1', false))) {
	$aspect = '16by9';
}
if ($aspect) {
	$class .= sprintf(' embed-responsive embed-responsive-%s', $aspect);
}

if (!empty($source)) {
	if (strpos($source, 'youtube.com') !== false) {
		// YouTube
		$params = explode('&', parse_url($source, PHP_URL_QUERY));
		$service = 'youtube';

		if (!empty($params)) {
			foreach ($params as $param) {
				if (preg_match('/^v=(.*)/', $param, $matches)) {
					$key = $matches[1];
				}
			}
		}
	} elseif (strpos($source, 'vimeo.com') !== false) {
		// Vimeo
		$params = explode('/', parse_url($source, PHP_URL_PATH));
		$service = 'vimeo';

		if (!empty($params[1])) {
			$key = $params[1];
		}
	} elseif (strpos($source, 'facebook.com') !== false) {
		// Facebook
		$service = 'facebook';
		$key = $source;
	}
?>
<div <?php $id ? printf("id='%s'", $id) : ''; ?> class='<?php echo $class; ?>' data-component='video'>
	<?php
	$playerClass = $aspect ? 'embed-responsive-item' : '';

	// Video from an external service
	if (!empty($service) && !empty($key)):
	?>
	<iframe
		class='<?php echo $playerClass; ?>'
		src='<?php printf($services[$service]['url'], $key); ?>'
	>
	</iframe>
	<?php endif; ?>

	<?php
	// Local video
	if (empty($service)):
		$attrs = [
			'controls' => true
		];

		if ($aspect) {
			$attrs['class'] = 'embed-responsive-item';
		}
		if (isset($controls)) {
			$attrs['controls'] = $controls;
		}
		if (!empty($autoplay)) {
			$attrs['autoplay'] = true;
			$attrs['muted'] = true;
			$attrs['playsinline'] = true;
		}
		if (!empty($loop)) {
			$attrs['loop'] = true;
		}
		if (!empty($poster)) {
			$attrs['poster'] = $poster;
		}
	?>
	<?php echo $this->Html->tag('video', null, $attrs); ?>
		<source src='<?php echo $source; ?>' type='video/mp4'>

		<?php __("I'm sorry; your browser doesn't support HTML5 video in MP4 with H.264."); ?>
	</video>
	<?php endif; ?>
</div>
<?php
}
?>
