<?php
$id = empty($id) ? '' : $id;
$class = sprintf('google-cse-component%s', (empty($class) ?  '' : ' ' . $class));
$key = isset($key) ? $key : '';

$this->Package->append('component', 'css', array(
	'component.google-cse'
));
?>
<div <?php $id ? printf("id='%s'", $id) : ''; ?> class='<?php echo $class; ?>' data-component='google-cse'>
	<script>
	(function() {
		var cx = '<?php echo $key; ?>';
		var gcse = document.createElement('script');
		gcse.type = 'text/javascript';
		gcse.async = true;
		gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(gcse, s);
	})();
	</script>

	<gcse:searchresults-only></gcse:searchresults-only>
</div>
