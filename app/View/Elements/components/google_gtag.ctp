<?php
// Global site tag (gtag.js)
// See https://developers.google.com/gtagjs

// Google Analytics, Google Ads, etc.
$product = isset($product) ? $product : '';
$targetId = !empty($targetId) ? $targetId : '';
// As we cannot override view's config var, set config to empty
// when config has the key 'App'
$config = empty($config) || isset($config['App']) ? [] : $config;

if (empty($targetId) && $product == 'Google Analytics') {
	if (!empty(Configure::read('App.configurations.analytics-id'))) {
		$targetId = Configure::read('App.configurations.analytics-id');
	} elseif (!empty(Configure::read('App.services.ga.account'))) {
		$targetId = Configure::read('App.services.ga.account');
	}
}
?>
<?php if (!empty($targetId)): ?>
<!-- Global site tag (gtag.js) -->
<script async src='https://www.googletagmanager.com/gtag/js?id=<?php echo $targetId; ?>'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $targetId; ?>', <?php echo empty($config) ? '{}' : json_encode($config); ?>);
</script>
<?php endif; ?>
