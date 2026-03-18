<!DOCTYPE html>
<html lang='<?php echo $locale ?>'>
	<head>
		<meta charset='utf-8' />
		<meta http-equiv='X-UA-Compatible' content='IE=edge' />

		<title><?php echo Sanitize::html($this->fetch('title'), array('double' => false)); ?></title>

		<!-- Meta -->
		<?php
		echo $this->Html->meta('description', $this->fetch('pageDescription', $config['App']['description']));
		echo $this->Html->meta(array('name' => 'author', 'content' => 'affenbits'));
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, user-scalable=no'));
		echo $this->fetch('meta');
		?>

		<!-- Links -->
		<link rel='author' href='https://affenbits.com' />
		<link rel='icon' href='/simian.ico'>

		<!-- Resource hints -->
		<link rel='dns-prefetch' href='//fonts.googleapis.com'>
		<link rel='preconnect' href='https://fonts.gstatic.com/' crossorigin>

		<!-- Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Roboto&display=swap' rel='stylesheet'>

		<!-- CSS -->
		<?php
		echo $this->Package->css(
			array_merge(
				array(
					'component.font-awesome-5.fontawesome',
					'component.font-awesome-5.solid',
					'component.alertify',
					'site.component.bootstrap-4',
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
		<!-- Content -->
		<?php echo $this->fetch('content'); ?>

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
					'vendor.jquery.jquery',
					'vendor.bootstrap.transition',
					'vendor.bootstrap.collapse',
					'vendor.bootstrap.alert'
				),
				$assets['scripts'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php
		if (Configure::read('debug') == 0) {
			echo $this->element('components/google_analytics');
		}
		?>

		<?php
		if (Configure::read('App.dev.sql')) {
			echo $this->element('sql_dump');
		}
		?>
	</body>
</html>
