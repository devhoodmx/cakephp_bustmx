<?php
// Requires stylesheet component.font-awesome-5.brands
$style = isset($style) ? $style : 'logo';
$class = 'social-component' . (isset($class) ? ' ' . $class : '');
$networks = array(
	'facebook' => array(
		'icon' => array(
			'logo' => 'facebook-f',
			'square' => 'facebook-square'
		),
		'url' => 'https://www.facebook.com/%s',
		'name' => __('Facebook')
	),
	'instagram' => array(
		'icon' => array(
			'logo' => 'instagram',
			'square' => 'instagram-square'
		),
		'url' => 'https://www.instagram.com/%s',
		'name' => __('Instagram')
	),
	'google-plus' => array(
		'icon' => array(
			'logo' => 'google-plus-g',
			'square' => 'google-plus-square'
		),
		'url' => 'https://plus.google.com/%s',
		'name' => __('Google +')
	),
	'youtube' => array(
		'icon' => array(
			'logo' => 'youtube',
			'square' => 'youtube-square'
		),
		'url' => 'https://www.youtube.com/user/%s',
		'name' => __('YouTube')
	),
	'twitter' => array(
		'icon' => array(
			'logo' => 'twitter',
			'square' => 'twitter-square'
		),
		'url' => 'https://twitter.com/%s',
		'name' => __('Twitter')
	),
	'linkedin' => array(
		'icon' => array(
			'logo' => 'linkedin-in',
			'square' => 'linkedin'
		),
		'url' => 'https://www.linkedin.com/in/%s',
		'name' => __('LinkedIn')
	),
	'pinterest' => [
		'icon' => [
			'logo' => 'pinterest',
			'square' => 'pinterest-square'
		],
		'url' => 'https://www.pinterest.com/%s',
		'name' => __('Pinterest')
	]
);

if (!in_array($style, array('logo', 'square'))) {
	$style = 'logo';
}

$this->Package->append('component', 'css', array(
	'component.social'
));
?>

<?php if (!empty($items)): ?>
<ul <?php isset($id) ? printf("id='%s'", $id) : ''; ?> class='<?php echo $class; ?>'>
	<?php
	foreach ($items as $key => $item):
		if (!empty($item['network']) && !empty($networks[$item['network']])):
			$class = sprintf('social-item social-%s', $item['network']);
			$network = $networks[$item['network']];
	?>
	<li class='<?php echo $class; ?>'>
		<?php
		$title = '';
		$url = $item['account'];
		$icon = $network['icon'][$style];

		if (!preg_match('/^https?/i', $item['account'])) {
			$url = sprintf($network['url'], $item['account']);
		}
		// Icon
		if (isset($item['icon'])) {
			$icon = $item['icon'];
		}
		if ($icon) {
			if (is_array($icon) && isset($icon['type']) && $icon['type'] == 'image') {
				$title .= $this->Html->image(
					$icon['source'],
					[
						'class' => sprintf(
							'social-icon social-%s-icon social-icon-image',
							$item['network']
						),
						'alt' => $network['name']
					]
				);
			} else {
				$title .= sprintf(
					"<i class='social-icon social-%s-icon fab fa-fw fa-%s'></i>",
					$item['network'],
					$icon
				);
			}
		}
		// Title
		if (!empty($item['title'])) {
			$title .= str_replace('{{ account }}', $item['account'], $item['title']);
		}

		echo $this->Html->link(
			$title,
			$url,
			array(
				'class' => sprintf('social-option social-%s-option', $item['network']),
				'target' => '_blank',
				'escape' => false
			)
		);
		?>
	</li>
	<?php
		endif;
	endforeach;
	?>
</ul>
<?php endif; ?>
