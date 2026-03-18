<!DOCTYPE html>
<html lang='<?php echo $locale ?>'>
	<head>
		<meta charset='utf-8' />

		<title><?php echo Sanitize::html($this->fetch('title'), array('double' => false)); ?></title>

		<!-- Meta -->
		<?php
		echo $this->Html->meta('description', $this->fetch('pageDescription', $config['App']['configurations']['website-description']));
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'));
		echo $this->fetch('meta');

		$socialMetaImage = $this->fetch('setSocialMetaImage', null);

		echo $this->Html->meta(array('property' => 'og:type', 'content' => 'website'));
		echo $this->Html->meta(array('property' => 'og:url', 'content' => $this->Html->url(null, true)));
		echo $this->Html->meta(array('property' => 'og:title', 'content' => $this->fetch('setSocialMetaTitle', $this->fetch('title'))));
		echo $this->Html->meta(array('property' => 'og:description', 'content' => $this->fetch('setSocialMetaDescription', $config['App']['configurations']['website-description'])));

		if (!empty($socialMetaImage)) {
			echo $this->Html->meta(array('property' => 'og:image', 'content' => $socialMetaImage));
			echo $this->Html->meta(array('property' => 'og:image:alt', 'content' => $this->fetch('setSocialMetaTitle', $this->fetch('title'))));
		}

		echo $this->Html->meta(array('property' => 'twitter:card', 'content' => 'summary_large_image'));
		echo $this->Html->meta(array('property' => 'twitter:url', 'content' => $this->Html->url(null, true)));
		echo $this->Html->meta(array('property' => 'twitter:title', 'content' => $this->fetch('setSocialMetaTitle', $this->fetch('title'))));
		echo $this->Html->meta(array('property' => 'twitter:description', 'content' => $this->fetch('setSocialMetaDescription', $config['App']['configurations']['website-description'])));
		if (!empty($socialMetaImage)) {
			echo $this->Html->meta(array('property' => 'twitter:image', 'content' => $socialMetaImage));
		}
		?>

		<!-- Links -->

		<!-- Fonts -->
		<!-- Icons -->
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		<!-- CSS -->
		<?php
		$_assets = [
			'[vendor]',
			'component.font-awesome-5.fontawesome',
			'component.font-awesome-5.solid',
			'component.font-awesome-5.regular',
		];

		if ($config['App']['configurations']['contact-chat-whatsapp'] &&
			!empty($config['App']['configurations']['contact-whatsapp'])) {
			$_assets[] = 'component.font-awesome-5.brands';
			$_assets[] = 'component.whatsapp';
		}

		echo $this->Package->css(
			array_merge(
				$_assets,
				array(
					'[component]',
					'site.component.bootstrap-4',
					'vendor.aos.aos',
 					'site.core.layout'
				),
				$assets['stylesheets'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php echo $this->fetch('style'); ?>

		<!-- JavaScript -->
		<?php
		echo $this->Package->js(
			array(
				'core.core'
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php echo $config['App']['configurations']['website-header-code']; ?>
		<?php echo $this->fetch('pageHeaderCode'); ?>
	</head>

	<!-- Document -->
	<body>
		<!-- Header -->
		<header class='doc-header'>
			<div class="bg-fixed"></div>
			<div class="container-menu">
				<?php echo $this->element('site/components/items-menu');?>
			</div>
			<div class="container container-header d-flex justify-content-end align-items-center">
				<?php echo $this->element('site/components/data-information');?>	
			</div>
			<!-- Nav -->
			<nav id='doc-nav'>
				
			</nav>
		</header>

		<!-- Body -->
		<main id='inicio' class='doc-body' role='main'>
			<?php echo $this->element('site/components/modal');;?>
			<?php echo $this->fetch('content'); ?>
		</main>

		<!-- Footer -->
		<footer class='doc-footer'>

			<?php echo $this->element('site/components/menu');?>

			<div class="container-fluid bootom-footer bg-black w-100 d-flex justify-content-between align-items-center">
				<div class="container-plataforms">
				<?php
					$networks = [
						'facebook' => [
							'target' => '_blank',
							'class' => 'icons'
											],
						'instagram' => [
							'target' => '_blank',
							'class' => 'icons'
						],
											
					];
					foreach ($networks as $network => $attr) :
						if (!empty($config['App']['configurations']['socialnetworks-' . $network])):
							echo $this->Html->link(
								$this->Html->image('/img/site/bust/icons/' . $network . '.svg', ["alt" => $network, 'class' => 'filter-invert']),
								$config['App']['configurations']['socialnetworks-' . $network],
								['target' => $attr['target'], 'class' => $attr['class'], 'escape' => false]
							);
						endif;
					endforeach;
				?>		
				</div>
				
				<?php
					echo  $this->Html->link(
						'Aviso de privacidad',
						['controller' => 'pages', 'action' => 'privacy'],
						['class' => 'font-25 text-white text-uppercase']
					)
				?>
			</div>
		</footer>

		<?php if (!empty($config['App']['configurations']['contact-chat-whatsapp'])): ?>
		<!-- Widgets -->
		<div class='doc-widgets'>
			<?php
			if ($config['App']['configurations']['contact-chat-whatsapp'] &&
				!empty($config['App']['configurations']['contact-whatsapp'])) {
				echo $this->element('components/whatsapp', [
					'class' => 'whatsapp-chat-link doc-widget',
					'phone' => $config['App']['configurations']['contact-whatsapp'],
					'title' => false
				]);
			}
			?>
		</div>
		<?php endif; ?>

		<?php echo $this->fetch('templates'); ?>
		<?php echo $this->fetch('modals'); ?>

		<!-- JavaScript -->
		<script>
			hozen.app.host = '<?php echo $_SERVER['SERVER_NAME']; ?>';
			hozen.app.baseURL = '<?php echo Router::url('/', true); ?>';
			hozen.app.locale = '<?php echo $locale; ?>';
			hozen.app.authenticated = false;
			hozen.app.authAccount = {};
		</script>

		<?php echo $this->fetch('script'); ?>

		<?php
		echo $this->Package->js(
			array_merge(
				array(
					'vendor.jquery-3.jquery',
					'vendor.bootstrap-4.util',
					'vendor.bootstrap-4.collapse',
					'vendor.bootstrap-4.tab',
					'vendor.bootstrap-4.dropdown',
					'vendor.bootstrap-4.collapse',
					'vendor.bootstrap-4.modal',
					'vendor.bootstrap.alert',
					'vendor.aos.aos',
					'[vendor]',
					'[component]',
					'core.bootstrap'
				),
				$assets['scripts'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php echo $this->fetch('posstyle'); ?>
		<?php echo $this->fetch('posscript'); ?>

		<?php
		if (Configure::read('debug') < 2) {
			echo $this->element('components/google_gtag', [
				'product' => 'Google Analytics'
			]);
		}
		?>

		<?php echo $config['App']['configurations']['website-footer-code']; ?>
		<?php echo $this->fetch('pageFooterCode'); ?>

		<?php
		if (Configure::read('App.dev.sql')) {
			echo $this->element('sql_dump');
		}
		?>
	</body>
</html>
