<?php
$id = !empty($id) ? $id : false;
$class = sprintf('recaptcha-component g-recaptcha%s', (empty($class) ?  '' : ' ' . $class));
$key = Configure::read('App.services.recaptcha.public-key');
$opts = array('key', 'theme', 'locale');
$optsMap = array(
	'key' => 'sitekey'
);
$data = array();

if (empty($locale)) {
	$locale = Configure::read('App.services.recaptcha.locales.' . Configure::read('App.locale'));
}

foreach ($opts as $opt) {
	if (isset($$opt)) {
		$optKey = isset($optsMap[$opt]) ? $optsMap[$opt] : $opt;

		$data[] = sprintf("data-%s='%s'", str_replace('_', '-', Inflector::underscore($optKey)), $$opt);
	}
}
?>

<?php if (!empty($key)): ?>
<?php
$url = sprintf(
	'https://www.google.com/recaptcha/api.js?render=explicit&onload=%s&hl=%s',
	'onRecaptchaLoaded',
	$locale
);

$this->Package->append('view', 'js', array(
	'component.recaptcha'
));
echo $this->Html->script($url, array('block' => 'posscript', 'defer' => true, 'async' => true, 'inline' => false));
?>

<div <?php echo !empty($id) ? "id='$id'" : ''; ?> class='<?php echo $class; ?>' data-component='recaptcha' <?php echo implode(' ', $data); ?>></div>

<?php
// Errors
if (!empty($recaptchaError)) :
	foreach ($recaptchaError as $errorMessage) :
?>
<div class='error-message'>
	<?php echo __d('recaptcha', $errorMessage); ?>
</div>
<?php
	endforeach;
endif;
?>
<?php endif; ?>
