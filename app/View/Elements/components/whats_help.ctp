<?php
// See https://getbutton.io/
$options = [
	'call_to_action' => __d('whats_help', 'call-to-action'),
	'button_color' => !empty($button_color) ? $button_color : '#FF6550',
	'position' => !empty($position) ? $position : 'left'
];
$order = [];

// Set apps
// The order of the buttons is defined by the order of the apps in $apps
if (!empty($apps) && is_array($apps)) {
	foreach ($apps as $app => $value) {
		$options[$app] = $value;
		$order[] = $app;
	}

	$options['order'] = implode(',', $order);
}
?>
<script type='text/javascript'>
	(function () {
		var options = <?php echo json_encode($options); ?>;
		var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
		s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
		var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
	})();
</script>
