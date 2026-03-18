<?php
$trackingId = empty($trackingId) ? '' : $trackingId;
if (empty($trackingId)) {
	if (!empty($config['App']['configurations']['analytics-id'])) {
		$trackingId = $config['App']['configurations']['analytics-id'];
	} elseif (!empty($config['App']['services']['ga']['account'])) {
		$trackingId = $config['App']['services']['ga']['account'];
	}
}
?>
<?php if (!empty($trackingId)): ?>
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $trackingId; ?>', 'auto');
  ga('send', 'pageview');
</script>
<?php endif; ?>
