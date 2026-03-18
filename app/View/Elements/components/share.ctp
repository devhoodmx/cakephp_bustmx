<?php
$services = !empty($services) ? $services : array('facebook', 'twitter', 'pinterest');
$services = array_combine($services, $services);

$class = sprintf('share-component%s', (empty($class) ?  '' : ' ' . $class));
$url = isset($url) ? $url : Router::url(null, true);
$urlEncoded = urlencode($url);

$this->Package->append('view', 'css', array(
	'component.share'
));
?>
<div class='<?php echo $class; ?>'>
	<ul class='share-list'>
		<?php
		/**
		 * Facebook
		 *
		 * See https://developers.facebook.com/docs/plugins/share-button/
		 */
		if (isset($services['facebook'])):
		?>
		<li class='share-item'>
			<div id='fb-root'></div>

			<div
				class='share-btn fb-share-button'
				data-href='<?php echo $url; ?>'
				data-layout='button'
				data-size='small'
				data-mobile-iframe='true'>
				<a class='fb-xfbml-parse-ignore' target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=<?php echo $urlEncoded; ?>&amp;src=sdkpreparse'>Share</a>
			</div>

<?php $this->append('posscript'); ?>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.1';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php $this->end(); ?>
		</li>
		<?php endif; ?>

		<?php
		/**
		 * Twitter
		 *
		 * See https://dev.twitter.com/web/tweet-button
		 */
		if (isset($services['twitter'])):
		?>
		<li class='share-item'>
			<a class='share-btn twitter-share-button' href='https://twitter.com/intent/tweet'>Tweet</a>


<?php $this->append('posscript'); ?>
<script>
window.twttr = (function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0],
	t = window.twttr || {};
if (d.getElementById(id)) return t;
js = d.createElement(s);
js.id = id;
js.src = 'https://platform.twitter.com/widgets.js';
fjs.parentNode.insertBefore(js, fjs);

t._e = [];
t.ready = function(f) {
	t._e.push(f);
};

return t;
}(document, 'script', 'twitter-wjs'));
</script>
<?php $this->end(); ?>
		</li>
		<?php endif; ?>

		<?php
		/**
		 * Pinterest
		 */
		if (isset($services['pinterest'])):
		?>
		<li class='share-item'>
			<div class='share-btn pinterest-button'>
				<a data-pin-do='buttonPin' href='https://www.pinterest.com/pin/create/button/?media=<?php echo $url; ?>'></a>
			</div>

<?php $this->append('posscript'); ?>
<script type='text/javascript'>
	(function(d){
		var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
		p.type = 'text/javascript';
		p.async = true;
		p.src = '//assets.pinterest.com/js/pinit.js';
		f.parentNode.insertBefore(p, f);
	}(document));
</script>
<?php $this->end(); ?>
		</li>
		<?php endif; ?>
	</ul>
</div>
