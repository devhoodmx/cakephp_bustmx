<!DOCTYPE html>
<html lang='<?php echo $locale ?>'>
	<head>
		<meta charset='utf-8' />

		<title><?php echo Sanitize::html($this->fetch('title'), array('double' => false)); ?></title>

		<!-- Meta -->
		<?php
		echo $this->Html->meta('description', $this->fetch('pageDescription', $config['App']['description']));
		echo $this->Html->meta(array('name' => 'author', 'content' => ''));
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'));
		echo $this->fetch('meta');
		?>

		<!-- Links -->
		<link rel='author' href='' />

		<!-- Fonts -->

		<!-- CSS -->
		<?php
		echo $this->Package->css(
			array_merge(
				array(
					'[vendor]',
					'component.font-awesome-5.fontawesome',
					'component.font-awesome-5.solid',
					'site.component.bootstrap-4',
 					'site.core.layout'
				),
				$assets['stylesheets'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<!-- JavaScript -->
		<?php
		echo $this->Package->js(
			array(
				'core.core'
			),
			array('compressed' => true, 'cached' => false)
		);
		?>
	</head>

	<!-- Document -->
	<body>
		<!-- Header -->
		<header class='doc-header'>
			<!-- Nav -->
			<nav id='doc-nav'></nav>
		</header>

		<!-- Body -->
		<main class='doc-body' role='main'>
			<?php echo $this->fetch('content'); ?>
		</main>

		<!-- Footer -->
		<footer class='doc-footer'>
		</footer>

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
					'[vendor]',
					'core.bootstrap'
				),
				$assets['scripts'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php echo $this->fetch('posscript'); ?>

		<?php
		if (Configure::read('debug') == 0) {
			echo $this->element('components/google_analytics');
		}
		?>

		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>
