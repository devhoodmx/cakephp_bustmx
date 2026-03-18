<?php
$messages = array(
	'default' => array('accept', 'delete')
);
$entries = array();

foreach ($messages as $domain => $value) {
	$entries[$domain] = array();

	foreach ($value as $message) {
		$entries[$domain][$message] = __d($domain, $message);
	}
}
?>
<script>
	hozen.locale['<?php echo $locale; ?>'] = <?php echo json_encode($entries); ?>;
</script>
